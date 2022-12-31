<?php


namespace App\Service;


use App\Entity\DelayedOrder;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;

class DelayedOrderAssignmentService
{
    private ?DelayedOrder $delayedOrder = null;
    private ?User $agent = null;
    private ?Order $order;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @throws Error
     */
    public function handle($delayedOrderDetails): ?DelayedOrder
    {
        $this->setData($delayedOrderDetails);
        $this->assignDelayedOrderToAgent();

        return $this->delayedOrder;
    }

    /**
     * @throws Error
     */
    private function setData($delayedOrderDetails)
    {
        $this->setOrder($delayedOrderDetails);
        $this->setAgent($delayedOrderDetails);
    }

    /**
     * @throws Error
     */
    private function setOrder($delayedOrderDetails)
    {
        $order = $this->entityManager->getRepository(Order::class)
            ->findBy($delayedOrderDetails['orderId']);

        if (empty($order)) {
            throw new Error("Could not find order for specified ID");
        }

        $this->order = $order;
    }

    /**
     * @throws Error
     */
    private function setAgent($delayedOrderDetails)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->find($delayedOrderDetails['agentId']);


        if (is_null($user)) {
            throw new Error("Could not find user for specified ID");
        }

        $this->agent = $user;
    }

    /**
     * @throws Error
     */
    private function assignDelayedOrderToAgent()
    {
        $this->inspectRules();

        $this->delayedOrder->setAgent($this->agent);
        $this->entityManager->persist($this->delayedOrder);
        $this->entityManager->flush();
    }

    /**
     * if delayed order is already assigned and checking process has not been completed,
     * then delayed order must not assign to another agent.
     * @throws Error
     */
    private function inspectRules()
    {
        $this->inspectDelayedOrderRule();
        $this->inspectAgentRule();
    }

    /**
     * @throws Error
     */
    private function inspectDelayedOrderRule()
    {
        if ($this->order->hasCheckingAndAssignedRecordInQueue()) {
            throw new Error("You can not assign this delayed order as it is in-progress.");
        }
    }

    /**
     * @throws Error
     */
    private function inspectAgentRule()
    {
        if($this->agent->hasInProgressDelayedOrder()){
            throw new Error(
                "You can not assign the delayed order to this agent as he/she has in-progress delayed order."
            );
        }
    }
}
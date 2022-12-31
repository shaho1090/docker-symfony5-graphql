<?php


namespace App\Service\DelayedOrderAssignment;


use App\Entity\DelayedOrder;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;

class ManuallyAssignmentService
{
    private ?DelayedOrder $delayedOrder = null;
    private ?User $agent = null;

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
        $delayedOrder = $this->entityManager->getRepository(DelayedOrder::class)
            ->find($delayedOrderDetails['id']);

        if (empty($delayedOrder)) {
            throw new Error("Could not find delayed order for specified ID");
        }

        $this->delayedOrder = $delayedOrder;
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
        $this->delayedOrder->setState($this->delayedOrder::STATE_CHECKING);
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
        if ($this->delayedOrder->isInProgress()) {
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
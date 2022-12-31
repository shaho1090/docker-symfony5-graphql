<?php


namespace App\Service\DelayedOrderAssignment;


use App\Entity\DelayedOrder;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;

abstract class AbstractAssignmentService
{
    protected ?DelayedOrder $delayedOrder = null;
    protected ?User $agent = null;


    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {
    }

    abstract protected function setData($delayedOrderDetails);

    /**
     * @param User $agent
     */
    protected function setAgent(User $agent)
    {
        $this->agent = $agent;
    }

    /**
     * @param DelayedOrder $delayedOrder
     */
    protected function setDelayedOrder(DelayedOrder $delayedOrder)
    {
        $this->delayedOrder = $delayedOrder;
    }

    /**
     * @throws Error
     */
    protected function assignDelayedOrderToAgent()
    {
        $this->inspectRules();

        $this->delayedOrder->setAgent($this->agent);
        $this->delayedOrder->setState($this->delayedOrder::STATE_CHECKING);
        $this->entityManager->persist($this->delayedOrder);
        $this->entityManager->flush();
    }

    /**
     * @throws Error
     */
    public function findAgent(int $agentId)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->find($agentId);

        if (is_null($user)) {
            throw new Error("Could not find user for specified ID");
        }

        return $user;
    }

    /**
     * @param int $delayedOrderId
     * @return DelayedOrder
     * @throws Error
     */
    public function findDelayedOrder(int $delayedOrderId): DelayedOrder
    {
        $delayedOrder = $this->entityManager->getRepository(DelayedOrder::class)
            ->find($delayedOrderId);

        if (empty($delayedOrder)) {
            throw new Error("Could not find delayed order for specified ID");
        }

        return $delayedOrder;
    }

    /**
     * if delayed order is already assigned and checking process has not been completed,
     * then delayed order must not assign to another agent.
     * @throws Error
     */
    protected function inspectRules()
    {
        $this->inspectDelayedOrderRule();
        $this->inspectAgentRule();
    }

    /**
     * @throws Error
     */
    protected function inspectDelayedOrderRule()
    {
        if ($this->delayedOrder->isInProgress()) {
            throw new Error("You can not assign this delayed order as it is in-progress.");
        }
    }

    /**
     * @throws Error
     */
    protected function inspectAgentRule()
    {
        if($this->agent->hasInProgressDelayedOrder()){
            throw new Error(
                "You can not assign the delayed order to this agent as he/she has in-progress delayed order."
            );
        }
    }
}
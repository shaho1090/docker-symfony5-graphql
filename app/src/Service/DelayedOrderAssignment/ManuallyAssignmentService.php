<?php


namespace App\Service\DelayedOrderAssignment;


use App\Entity\DelayedOrder;
use GraphQL\Error\Error;

class ManuallyAssignmentService extends AbstractAssignmentService
{
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
        $this->setDelayedOrder(
            $this->findDelayedOrder($delayedOrderDetails['id'])
        );

        $this->setAgent(
            $this->findAgent($delayedOrderDetails['agentId'])
        );
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
        if ($this->agent->hasInProgressDelayedOrder()) {
            throw new Error(
                "You can not assign the delayed order to this agent as he/she has in-progress delayed order."
            );
        }
    }
}
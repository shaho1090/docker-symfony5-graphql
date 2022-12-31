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
    protected function setData($delayedOrderDetails)
    {
        $this->setDelayedOrder(
            $this->findDelayedOrder($delayedOrderDetails['id'])
        );

        $this->setAgent(
            $this->findAgent($delayedOrderDetails['agentId'])
        );
    }
}
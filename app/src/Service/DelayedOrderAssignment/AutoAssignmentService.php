<?php


namespace App\Service\DelayedOrderAssignment;


use App\Entity\DelayedOrder;
use App\Repository\DelayedOrderRepository;
use GraphQL\Error\Error;

class AutoAssignmentService extends AbstractAssignmentService
{
    /**
     * @param $delayedOrderDetails
     * @return DelayedOrder|null
     * @throws Error
     */
    public function handle($delayedOrderDetails): ?DelayedOrder
    {
        $this->setData($delayedOrderDetails);
        $this->assignDelayedOrderToAgent();

        return $this->delayedOrder;
    }

    /**
     * @param $delayedOrderDetails
     * @throws Error
     */
    protected function setData($delayedOrderDetails)
    {
        $this->setAgent(
            $this->findAgent($delayedOrderDetails['agentId'])
        );

        $this->setDelayedOrder(
            $this->findFirstUnassignedDelayedOrder()
        );
    }


    /**
     * @return DelayedOrder|null
     * @throws Error
     */
    private function findFirstUnassignedDelayedOrder(): ?DelayedOrder
    {
        /** @var DelayedOrderRepository $delayedOrderRepository */
        $delayedOrderRepository = $this->entityManager->getRepository(DelayedOrder::class);

        $delayedOrders = $delayedOrderRepository->findBy(
            ['agent' => null],
            ['id' => 'ASC']
        );

        if(empty($delayedOrders)){
            throw new Error(
                "There is no unassigned order in delayed queue!"
            );
        }

       return $delayedOrders[0];
    }
}
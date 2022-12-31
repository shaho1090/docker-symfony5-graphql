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

    /**
     * @param User $agent
     */
    protected function setAgent(User $agent)
    {
        $this->agent = $agent;
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
     * @param DelayedOrder $delayedOrder
     */
    protected function setDelayedOrder(DelayedOrder $delayedOrder)
    {
        $this->delayedOrder = $delayedOrder;
    }
}
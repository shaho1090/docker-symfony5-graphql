<?php

namespace App\Service\TripState\States;


use App\Entity\TripState;
use App\Service\TripState\States\Interfaces\TripStateInterface;

class TripStateMap
{

    /**
     * @var string[]
     */
    private array $stateMap;

    public function __construct()
    {
        $this->mapStates();
    }

    public function resolveState(string $state): ?TripStateInterface
    {
        if (isset($this->stateMap[$state])) {
            return new $this->stateMap[$state];
        }

        return null;
    }

    private function mapStates()
    {
        $this->stateMap = [
            TripState::STATE_ASSIGNED => Assigned::class,
            TripState::STATE_AT_VENDOR => AtVendor::class,
            TripState::STATE_PICKED => Picked::class,
            TripState::STATE_DELIVERED => Delivered::class
        ];
    }
}
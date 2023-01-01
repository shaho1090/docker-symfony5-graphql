<?php


namespace App\Service\TripState\States;


use App\Entity\Trip;
use App\Entity\TripState;
use App\Service\TripState\States\Interfaces\AtVendorState;
use App\Service\TripState\States\Interfaces\TripStateInterface;

class AtVendor extends AbstractTripClass implements AtVendorState
{
    public function picked(Trip $trip): Trip
    {
        return $this->changeTripState($trip, TripState::STATE_PICKED);
    }
}
<?php


namespace App\Service\TripState\States;


use App\Entity\Trip;
use App\Entity\TripState;
use App\Service\TripState\States\Interfaces\PickedState;

class Picked extends AbstractTripClass implements PickedState
{
    public function Delivered(Trip $trip): Trip
    {
        return $this->changeTripState($trip, TripState::STATE_DELIVERED);
    }
}
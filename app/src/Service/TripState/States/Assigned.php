<?php


namespace App\Service\TripState\States;


use App\Entity\Trip;
use App\Entity\TripState;
use App\Service\TripState\States\Interfaces\AssignedState;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Assigned extends AbstractTripClass implements AssignedState
{
    /**
     */
    public function atVendor(Trip $trip): Trip
    {
        return $this->changeTripState($trip, TripState::STATE_AT_VENDOR);
    }
}
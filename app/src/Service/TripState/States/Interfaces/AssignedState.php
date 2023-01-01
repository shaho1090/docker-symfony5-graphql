<?php


namespace App\Service\TripState\States\Interfaces;


use App\Entity\Trip;

interface AssignedState
{
    public function atVendor(Trip $trip);
}
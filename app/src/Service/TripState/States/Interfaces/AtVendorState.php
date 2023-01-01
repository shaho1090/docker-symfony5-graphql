<?php


namespace App\Service\TripState\States\Interfaces;


use App\Entity\Trip;
use App\Entity\TripState;

interface AtVendorState
{
    public function picked(Trip $trip);
}
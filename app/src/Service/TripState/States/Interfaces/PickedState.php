<?php


namespace App\Service\TripState\States\Interfaces;


use App\Entity\Trip;

interface PickedState
{
    public function Delivered(Trip $trip);
}
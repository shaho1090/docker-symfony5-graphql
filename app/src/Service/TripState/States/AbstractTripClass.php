<?php


namespace App\Service\TripState\States;


use App\Entity\Trip;
use App\Entity\TripState;
use App\Service\TripState\States\Interfaces\TripStateInterface;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractTripClass implements TripStateInterface
{
    protected Trip $trip;

    /**
     * @var EntityManagerInterface|null
     * @inject
     */
    public ?EntityManagerInterface $entityManager = null;

    protected function changeTripState(Trip $trip, string $nextState): Trip
    {
        $newTripState = new TripState();
        $newTripState->setState($nextState);
        $newTripState->setCreatedAt(Carbon::now());
        $newTripState->setTrip($trip);

        $this->entityManager->persist($newTripState);
        $this->entityManager->flush();
        $this->entityManager->refresh($trip);
        return $trip;
    }

    /**
     * @param EntityManager $entityManager
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $entityManager): static
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}
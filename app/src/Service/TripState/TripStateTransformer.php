<?php


namespace App\Service\TripState;


use App\Entity\Trip;
use App\Entity\TripState;
use App\Service\TripState\States\Interfaces\TripStateInterface;
use App\Service\TripState\States\TripStateMap;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;


class TripStateTransformer
{
    private ?TripStateInterface $currentTripState;
    private TripStateMap $tripStateMap;
    private Trip $tripEntity;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->tripStateMap = new TripStateMap();
    }

    /**
     * @throws Error
     */
    public function handle(Trip $tripEntity, string $nextState): Trip
    {
        $this->tripEntity = $tripEntity;
        $this->validateState($nextState);
        $this->setStateClass();
        $this->changeStateTo($nextState);

        return $tripEntity;
    }

    /**
     * @throws Error
     */
    private function changeStateTo(string $state)
    {
        $method = $this->covertToMethod($state);

        if (method_exists($this->currentTripState, $method)) {
            $this->currentTripState->setEntityManager($this->entityManager)->$method($this->tripEntity);
            return;
        }

        throw  new Error(
            "Illegal trip state transition: $method"
        );
    }

    private function setStateClass()
    {
        $currentState = $this->tripEntity->getCurrentState();

        if (is_null($currentState)) {
            $currentState = $this->makeAssignedStateForTrip()->getState();
        }

        $this->currentTripState = $this->tripStateMap->resolveState($currentState);
    }

    /**
     * @throws Error
     */
    private function validateState(string $nextState)
    {
        if (in_array($nextState, TripState::getAllStates())) {
            return;
        }

        throw new Error(
            "The state: $nextState, does not exist!"
        );
    }

    private function covertToMethod(string $state): string
    {
        return str_replace(' ', '', lcfirst(ucwords(str_replace('_', ' ', $state))));
    }

    private function makeAssignedStateForTrip(): TripState
    {
        $assignedTripState = new TripState();
        $assignedTripState->setState(TripState::STATE_ASSIGNED);
        $assignedTripState->setCreatedAt(Carbon::now());

        $assignedTripState->setTrip($this->tripEntity);

        $this->entityManager->persist($assignedTripState);
        $this->entityManager->flush();

        return $assignedTripState;
    }
}
<?php


namespace App\Service\Graphql;


use App\Entity\DelayReport;
use App\Entity\Order;
use App\Entity\Trip;
use App\Entity\TripState;
use App\Entity\User;
use App\Entity\Vendor;
use App\Repository\DelayReportRepository;
use App\Repository\OrderRepository;
use App\Repository\TripRepository;
use App\Repository\TripStateRepository;
use App\Repository\UserRepository;
use App\Repository\VendorRepository;
use Doctrine\Common\Collections\Collection;

class QueryService
{
    public function __construct(
        private UserRepository $userRepository,
        private OrderRepository $orderRepository,
        private VendorRepository $vendorRepository,
        private DelayReportRepository $delayReportRepository,
        private TripRepository $tripRepository,
        private TripStateRepository $tripStateRepository
    )
    {
    }

    public function findUser(int $userId): ?User
    {
        return $this->userRepository->find($userId);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function findOrdersByUser(string $name): Collection
    {
        return $this
            ->userRepository
            ->findOneBy(['name' => $name])
            ->getOrders();
    }

    public function findAllOrders(): array
    {
        return $this->orderRepository->findAll();
    }

    public function findOrderById(int $orderId): ?Order
    {
        return $this->orderRepository->find($orderId);
    }

    public function findVendor(int $vendorId): ?Vendor
    {
        return $this->vendorRepository->find($vendorId);
    }

    public function findAllVendors(): ?array
    {
        return $this->vendorRepository->findAll();
    }

    public function findDelayReport(int $delayReportId): ?DelayReport
    {
        return $this->delayReportRepository->find($delayReportId);
    }

    public function findAllDelayReports(): array
    {
        return $this->delayReportRepository->findAll();
    }

    public function findTripById($tripId): ?Trip
    {
        return $this->tripRepository->find($tripId);
    }

    public function findStatesByTripId($tripId): Collection
    {
        return $this->tripRepository->find($tripId)->getStates();
    }

    public function findState($stateId): TripState
    {
        return $this->tripStateRepository->find($stateId);
    }
}
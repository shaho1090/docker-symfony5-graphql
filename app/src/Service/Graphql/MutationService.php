<?php


namespace App\Service\Graphql;


use App\Entity\DelayedOrder;
use App\Entity\DelayReport;
use App\Entity\Order;
use App\Entity\Trip;
use App\Entity\TripState;
use App\Entity\User;
use App\Entity\Vendor;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Repository\VendorRepository;
use App\Service\DelayedOrderAssignment\AutoAssignmentService;
use App\Service\DelayedOrderAssignment\ManuallyAssignmentService;
use App\Service\Factory\DelayReportFactoryService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GraphQL\Error\Error;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MutationService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
        private VendorRepository $vendorRepository,
        private OrderRepository $orderRepository,
        private DelayReportFactoryService $delayReportFactoryService,
        private ManuallyAssignmentService $manuallyAssignmentService,
        private AutoAssignmentService $autoAssignDelayedOrder,
    )
    {
    }

    public function createUser(array $userDetails): User
    {
        $user = new User();

        $user->setPassword($this->passwordHasher->hashPassword($user, $userDetails['password']));
        $user->setName($userDetails['name']);
        $user->setFamily($userDetails['family']);
        $user->setEmail($userDetails['email']);
        $user->setPhone($userDetails['phone'] ?? null);

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    public function createVendor(array $vendorDetails): Vendor
    {
        $vendor = new Vendor();

        $vendor->setTitle($vendorDetails['title']);
        $vendor->setPhone($vendorDetails['phone']);
        $vendor->setAddress($vendorDetails['address'] ?? null);

        $slug = str_replace(" ", "-", strtolower($vendorDetails['title']));
        $vendor->setSlug($slug);

        $this->manager->persist($vendor);
        $this->manager->flush();

        return $vendor;
    }

    public function createOrder(array $orderDetails): Order
    {
        $order = new Order();

        $order->setCustomer($this->userRepository->find($orderDetails['customerId']));
        $order->setVendor($this->vendorRepository->find($orderDetails['vendorId']));
        $order->setDeliveryTime($orderDetails['deliveryTime']);
        $order->setDeliveryAddress($orderDetails['deliveryAddress']);
        $order->setDescription($orderDetails['description'] ?? null);
        $now = Carbon::now();
        $order->setCreatedAt($now);
        $order->setUpdatedAt($now);
        $beDeliveredAt = Carbon::parse($now)->addMinutes($orderDetails['deliveryTime']);
        $order->setBeDeliveredAt($beDeliveredAt);

        $this->manager->persist($order);
        $this->manager->flush();

        return $order;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function createTrip(array $tripDetails): Trip
    {
        $now = Carbon::now();

        $this->manager->getConnection()->beginTransaction();

        try {
            $trip = new Trip();

            $trip->setCourier($this->userRepository->find($tripDetails['courierId']));
            $trip->setOrder($this->orderRepository->find($tripDetails['orderId']));
            $trip->setDescription($tripDetails['description']);
            $trip->setCreatedAt($now);

            $this->manager->persist($trip);
            $this->manager->flush();

            $state = new TripState();
            $state->setCreatedAt($now);
            $state->setState($state::STATE_ASSIGNED);
            $state->setTrip($trip);

            $this->manager->persist($state);
            $this->manager->flush();
            $this->manager->getConnection()->commit();

        } catch (Exception $e) {
            $this->manager->getConnection()->rollBack();
            throw $e;
        }

        return $trip;
    }

    /**
     * @throws Exception
     */
    public function createDelayReport($delayReportDetails): DelayReport|String|null
    {
        return $this->delayReportFactoryService->create($delayReportDetails);
    }


    /**
     * @throws Error
     */
    public function assignDelayedOrder($delayedOrderDetails): ?DelayedOrder
    {
        return $this->manuallyAssignmentService->handle($delayedOrderDetails);
    }

    /**
     * @throws Error
     */
    public function autoAssignDelayedOrder($delayedOrderDetails): ?DelayedOrder
    {
        return $this->autoAssignDelayedOrder->handle($delayedOrderDetails);
    }
}
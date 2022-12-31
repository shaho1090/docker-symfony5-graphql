<?php


namespace App\Service\Factory;


use App\Entity\Order;
use App\Entity\User;
use App\Entity\Vendor;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;

class OrderFactoryService
{
    private User $customer;
    private Vendor $vendor;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {}

    /**
     * @throws Error
     */
    public function create(array $orderDetails): Order
    {
        $this->setRelations($orderDetails);
        return $this->createOrder($orderDetails);
    }

    /**
     * @throws Error
     */
    private function setRelations($orderDetails)
    {
        $this->setCustomer(
            $this->findCustomer($orderDetails['customerId'])
        );

        $this->setVendor(
            $this->findVendor($orderDetails['vendorId'])
        );
    }

    private function setCustomer(User $Customer)
    {
        $this->customer = $Customer;
    }

    /**
     * @throws Error
     */
    private function findCustomer($customerId)
    {
        $customer = $this->entityManager->getRepository(User::class)
            ->find($customerId);

        if(is_null($customer)){
            throw new Error(
                "Could not find user for specified ID"
            );
        }

        return $customer;
    }

    /**
     * @throws Error
     */
    private function findVendor($vendorId)
    {
        $vendor = $this->entityManager->getRepository(Vendor::class)
            ->find($vendorId);

        if(is_null($vendor)){
            throw new Error(
                "Could not find vendor for specified ID"
            );
        }

        return $vendor;
    }

    private function setVendor(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    private function createOrder($orderDetails): Order
    {
        $now = Carbon::now();
        $order = new Order();

        $order->setCustomer($this->customer);
        $order->setVendor($this->vendor);
        $order->setDeliveryTime($orderDetails['deliveryTime']);
        $order->setDeliveryAddress($orderDetails['deliveryAddress']);
        $order->setDescription($orderDetails['description'] ?? null);

        $order->setCreatedAt($now);
        $order->setUpdatedAt($now);
        $beDeliveredAt = Carbon::parse($now)->addMinutes($orderDetails['deliveryTime']);
        $order->setBeDeliveredAt($beDeliveredAt);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}
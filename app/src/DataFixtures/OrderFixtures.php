<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    const REFERENCE = "ORDERS_REFERENCE";
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $manager->persist(
                $this->getFakeOrder()
            );
        }

        $referenceVendor = $this->getFakeOrder();

        $this->addReference(self::REFERENCE, $referenceVendor);

        $manager->persist($referenceVendor);
        $manager->flush();
    }

    private function getFakeOrder(): Order
    {
        $deliveryTimes = [10, 20, 30, 40, 50, 60];
        $now = $this->faker->datetime();
        $order = new Order();

        $order->setCustomer($this->getReference(UserFixtures::REFERENCE));
        $order->setVendor($this->getReference(VendorFixtures::REFERENCE));

        $order->setDescription($this->faker->sentence());
        $order->setDeliveryTime($this->faker->randomElement($deliveryTimes));
        $order->setCreatedAt($now);
        $order->setUpdatedAt($now);

        return $order;
    }

    public function getDependencies(): array
    {
       return [
           UserFixtures::class,
           VendorFixtures::class
       ];
    }
}

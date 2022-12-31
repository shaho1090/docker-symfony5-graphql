<?php

namespace App\DataFixtures;

use App\Entity\Vendor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class VendorFixtures extends Fixture
{
    const REFERENCE = "VENDORS_REFERENCE";

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $manager->persist(
                $this->getFakeVendor()
            );
        }

        $referenceVendor = $this->getFakeVendor();

        $this->addReference(self::REFERENCE, $referenceVendor);

        $manager->persist($referenceVendor);
        $manager->flush();
    }

    private function getFakeVendor(): Vendor
    {
        $vendor = new Vendor();

        $title = $this->faker->words();
        $title = implode(" ", $title);
        $slug = str_replace(" ", "-", strtolower($title));

        $vendor->setTitle($title);
        $vendor->setSlug($slug);
        $vendor->setAddress($this->faker->address());

        return $vendor;
    }
}

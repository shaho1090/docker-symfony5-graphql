<?php

namespace App\DataFixtures;

use App\Entity\Vendor;
use App\Repository\VendorRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private VendorRepository $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function vendorId()
    {
        $vendors = $this->vendorRepository->findAll();

        $collection = new ArrayCollection($vendors);

        $vendors = $collection->toArray();

        $vendor = $vendors[array_rand($vendors)];

        return $vendor['id'];
    }
}

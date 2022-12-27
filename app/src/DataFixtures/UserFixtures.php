<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const REFERENCE = 'AUTHORS_REFERENCE';

    private Generator $faker;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create();
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $referenceUser = $this->getFakeUser();

        for ($i = 0; $i < 10; $i++) {
            $manager->persist(
                $referenceUser
            );
        }

        $this->addReference(self::REFERENCE, $referenceUser);

        $manager->persist($referenceUser);
        $manager->flush();
    }

    private function getFakeUser(): User
    {
        $user =  new User();

        $user->setName( $this->faker->firstName());
        $user->setFamily( $this->faker->lastName());
        $user->setEmail( $this->faker->email());
        $user->setPhone( $this->faker->phoneNumber());
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);

        return $user;
    }
}
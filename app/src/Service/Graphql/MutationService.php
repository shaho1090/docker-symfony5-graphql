<?php


namespace App\Service\Graphql;


use App\Entity\User;
use App\Entity\Vendor;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MutationService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function createUser(array $userDetails): User
    {
        $user = new User();

        $user->setPassword($this->passwordHasher->hashPassword($user,$userDetails['password']));
        $user->setName( $userDetails['name']);
        $user->setFamily( $userDetails['family']);
        $user->setEmail( $userDetails['email']);
        $user->setPhone($userDetails['phone'] ?? null);

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    public function createVendor(array $vendorDetails): Vendor
    {
        $vendor =  new Vendor();

        $vendor->setTitle($vendorDetails['title']);
        $vendor->setPhone($vendorDetails['phone']);
        $vendor->setAddress($vendorDetails['address'] ?? null);

        $slug = str_replace(" ", "-", strtolower($vendorDetails['title']));
        $vendor->setSlug($slug);

        $this->manager->persist($vendor);
        $this->manager->flush();

        return $vendor;
    }


//    public function updateBook(int $bookId, array $newDetails): Book
//    {
//        $book = $this->manager->getRepository(Book::class)->find($bookId);
//
//        if (is_null($book)) {
//            throw new Error("Could not find book for specified ID");
//        }
//
//        foreach ($newDetails as $property => $value) {
//            $book->$property = $value;
//        }
//
//        $this->manager->persist($book);
//        $this->manager->flush();
//
//        return $book;
//    }
}
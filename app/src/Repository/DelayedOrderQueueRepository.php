<?php

namespace App\Repository;

use App\Entity\DelayedOrderQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DelayedOrderQueue>
 *
 * @method DelayedOrderQueue|null find($id, $lockMode = null, $lockVersion = null)
 * @method DelayedOrderQueue|null findOneBy(array $criteria, array $orderBy = null)
 * @method DelayedOrderQueue[]    findAll()
 * @method DelayedOrderQueue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelayedOrderQueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DelayedOrderQueue::class);
    }

    public function save(DelayedOrderQueue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DelayedOrderQueue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DelayedOrderQueue[] Returns an array of DelayedOrderQueue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DelayedOrderQueue
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

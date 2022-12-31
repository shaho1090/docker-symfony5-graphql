<?php

namespace App\Repository;

use App\Entity\DelayedOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DelayedOrderQueue>
 *
 * @method DelayedOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method DelayedOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method DelayedOrder[]    findAll()
 * @method DelayedOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelayedOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DelayedOrder::class);
    }

    public function save(DelayedOrder $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DelayedOrder $entity, bool $flush = false): void
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

<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Promotions;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Promotions>
 *
 * @method Promotions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotions[]    findAll()
 * @method Promotions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotions::class);
    }

    public function save(Promotions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Promotions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findValidForProduct(Product $product, DateTimeInterface $requestDate)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.productPromotion', 'pp')
            ->andWhere('pp.product = :product')
            ->andWhere('pp.validTo > :requestDate OR pp.validTo IS NULL')
            ->setParameter('product', $product)
            ->setParameter('requestDate', $requestDate)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Promotions[] Returns an array of Promotions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Promotions
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
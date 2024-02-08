<?php

namespace App\Repository;

use App\Entity\EtatsFinancier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatsFinancier>
 *
 * @method EtatsFinancier|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatsFinancier|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatsFinancier[]    findAll()
 * @method EtatsFinancier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatsFinancierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatsFinancier::class);
    }

//    /**
//     * @return EtatsFinancier[] Returns an array of EtatsFinancier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EtatsFinancier
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

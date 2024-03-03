<?php

namespace App\Repository;

use App\Entity\InscriptionCertif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InscriptionCertif>
 *
 * @method InscriptionCertif|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionCertif|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionCertif[]    findAll()
 * @method InscriptionCertif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionCertifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionCertif::class);
    }

//    /**
//     * @return InscriptionCertif[] Returns an array of InscriptionCertif objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InscriptionCertif
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByUserId(int $userId)
{
    return $this->createQueryBuilder('i')
        ->andWhere('i.user = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
}

}

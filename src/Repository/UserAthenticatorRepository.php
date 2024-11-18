<?php

namespace App\Repository;

use App\Entity\UserAthenticator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAthenticator>
 *
 * @method UserAthenticator|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAthenticator|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAthenticator[]    findAll()
 * @method UserAthenticator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAthenticatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAthenticator::class);
    }

//    /**
//     * @return UserAthenticator[] Returns an array of UserAthenticator objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserAthenticator
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

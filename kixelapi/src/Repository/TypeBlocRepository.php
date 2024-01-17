<?php

namespace App\Repository;

use App\Entity\TypeBloc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeBloc>
 *
 * @method TypeBloc|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBloc|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBloc[]    findAll()
 * @method TypeBloc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBlocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBloc::class);
    }

    public function findByName($email): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.email = :val')
            ->setParameter('val', $email)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return TypeBloc[] Returns an array of TypeBloc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeBloc
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

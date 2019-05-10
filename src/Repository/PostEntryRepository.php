<?php

namespace App\Repository;

use App\Entity\PostEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PostEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostEntry[]    findAll()
 * @method PostEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostEntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostEntry::class);
    }

    // /**
    //  * @return PostEntry[] Returns an array of PostEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostEntry
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

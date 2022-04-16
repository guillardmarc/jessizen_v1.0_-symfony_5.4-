<?php

namespace App\Repository;

use App\Entity\Websites;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Websites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Websites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Websites[]    findAll()
 * @method Websites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Websites::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Websites $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Websites $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Websites[] Returns an array of Websites objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Websites
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function publicationByDate()
    {
        $date = (new DateTime())->format('Y-m-d');

        $query = $this->createQueryBuilder('w')
                      ->where('w.publicationDate <= :date')
                      ->setParameter('date', $date)
                      ->orderBy('w.publicationDate', 'DESC')
                      ->setMaxResults(1)
        ;
        return $query->getQuery()->getResult();
    }

    public function publicationByDatesingle()
    {
        $date = (new DateTime())->format('Y-m-d');

        $query = $this->createQueryBuilder('w')
                      ->where('w.publicationDate <= :date')
                      ->setParameter('date', $date)
                      ->orderBy('w.publicationDate', 'DESC')
                      ->setMaxResults(1)
        ;
        return $query->getQuery()->getSingleResult();
    }
}

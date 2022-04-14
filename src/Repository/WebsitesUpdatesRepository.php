<?php

namespace App\Repository;

use App\Entity\WebsitesUpdates;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WebsitesUpdates|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsitesUpdates|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsitesUpdates[]    findAll()
 * @method WebsitesUpdates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsitesUpdatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsitesUpdates::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(WebsitesUpdates $entity, bool $flush = true): void
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
    public function remove(WebsitesUpdates $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return WebsitesUpdates[] Returns an array of WebsitesUpdates objects
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
    public function findOneBySomeField($value): ?WebsitesUpdates
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function publicationDate()
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
}

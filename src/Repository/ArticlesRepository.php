<?php

namespace App\Repository;

use App\Entity\Articles;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Articles $entity, bool $flush = true): void
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
    public function remove(Articles $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Articles[] Returns an array of Articles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function lastFiveArticlesPublied()
    {
        $date = (new DateTime())->format('Y-m-d');

        return $this->createQueryBuilder('a')
            ->andWhere('a.publicationDate <= :date')
            ->setParameter('date', $date)
            ->orderBy('a.publicationDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function threeBestRatedArticlesPublied()
    {
        $date = (new DateTime())->format('Y-m-d');

        return $this->createQueryBuilder('a')
            ->andWhere('a.publicationDate <= :date')
            ->setParameter('date', $date)
            ->orderBy('a.note', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function fiveMostViewedArticlesPublied()
    {
        $date = (new DateTime())->format('Y-m-d');

        return $this->createQueryBuilder('a')
            ->andWhere('a.publicationDate <= :date')
            ->setParameter('date', $date)
            ->orderBy('a.viewNumber', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function lastFiveArticlesForCategory($idCategory)
    {
        $conn = $this->getEntityManager()->getConnection();
        $date = date("Y/m/d");
        $sql = "SELECT * FROM `articles` LEFT OUTER JOIN articles_categories on articles.id = articles_categories.articles_id WHERE articles_categories.categories_id = :idCategory and articles.publication_date <= :date ORDER BY articles.publication_date DESC LIMIT 5";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['date'=> $date, 'idCategory' => $idCategory],);
        return $resultSet->fetchAllAssociative();
    }

    public function threeBestRatedArticlesForCategory($category)
    {
        $conn = $this->getEntityManager()->getConnection();
        $date = date("Y/m/d");
        $sql = "SELECT * FROM `articles` LEFT OUTER JOIN articles_categories on articles.id = articles_categories.articles_id WHERE articles_categories.categories_id = :idCategory and articles.publication_date <= :date ORDER BY articles.publication_date DESC LIMIT 3";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['date'=> $date, 'idCategory' => $category]);
        return $resultSet->fetchAllAssociative();
    }

    public function fiveMostViewedArticlesForCategory($category)
    {
        $conn = $this->getEntityManager()->getConnection();
        $date = date("Y/m/d");
        $sql = "SELECT * FROM `articles` LEFT OUTER JOIN articles_categories on articles.id = articles_categories.articles_id WHERE articles_categories.categories_id = :idCategory and articles.publication_date <= :date ORDER BY articles.view_number DESC LIMIT 5";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['date'=> $date, 'idCategory' => $category]);
        return $resultSet->fetchAllAssociative();
    }
    
    public function articlesSortByDateForCategory($category)
    {
        $conn = $this->getEntityManager()->getConnection();
        $date = date("Y/m/d");
        $sql = "SELECT * FROM `articles` LEFT OUTER JOIN articles_categories on articles.id = articles_categories.articles_id WHERE articles_categories.categories_id = :idCategory and articles.publication_date <= :date ORDER BY articles.publication_date DESC";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['date'=> $date, 'idCategory' => $category]);
        return $resultSet->fetchAllAssociative();
    }
}

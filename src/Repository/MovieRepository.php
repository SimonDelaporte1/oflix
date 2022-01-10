<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * 
     * Liste des films par ordre alpha
     *
     * @return void
     */
    public function findAllOrderedByTitleAscDql()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m
            FROM App\Entity\Movie m
            ORDER BY m.duration ASC'
        );

        // returns an array of Movie objects
        return $query->getResult();
    }

    /**
     * Liste des films par ordre alpha
     * en Query Builder
     */
    public function findAllOrderedByTitleAscQb(string $search = null)
    {
        // Le Query Builder est créé depuis l'entité Movie référencée dans cette classe de Repository
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.title', 'ASC');
        
        // Search ?
        if ($search) {
            $query->where('m.title LIKE :search')
            ->setParameter('search', '%'.$search.'%');
        }

        return $query->getQuery()->getResult();
    }
    /**
     * Liste des films par ordre alpha
     * en Query Builder
     */
    public function findAllOrderedByDateAscQb()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.releaseDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
        /*
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m
            FROM App\Entity\Movie m
            ORDER BY m.releaseDate DESC'
        );

        
        // returns an array of Movie objects
        return $query->setMaxResults(2)->getResult();
        */
    }

    public function findOneRandomMovie()
    {
        // On peut se permettre de le faire en SQL pur
        // on va récupérer un tableau PHP ce qui est suffisant
        // on a juste besoin du slug et du title pour générer la route
        $dbalConnection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT *
            FROM `movie`
            ORDER BY RAND()
            LIMIT 1';
        
        $result = $dbalConnection->executeQuery($sql)->fetchAssociative();
        return $result;
    }

    /**
     * Get one random movie (DQL)
     */
    public function findOneRandomMovieDql()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m
            FROM App\Entity\Movie m
            ORDER BY RAND()'
        );

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

    public function findByGenre($genre)
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.genres', 'g')
            ->andWhere('g = :genre')
            ->setParameter('genre', $genre)
            ->getQuery()
            ->getResult();
    }

    

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Autor;
use App\Entity\Posts;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Posts>
 *
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    
    public function getValueAutor($id)
        {
            /*
            $result = $this->createQueryBuilder("q")
               // ->select('q.id')
               // ->where('q.id = ' . $id)
               //work >innerJoin(Autor::class, 'g', JOIN::WITH , 'q.id = g.id')
                ->innerJoin(Autor::class, 'g', JOIN::WITH , 'q.id = g.id')
                ->getQuery()
                ->getResult();

            return $result;
*/  
            $conn = $this->getEntityManager()->getConnection();

            $sql = '
                SELECT posts.id, posts.autor_id, autor.name FROM posts INNER JOIN autor ON posts.autor_id = autor.id 
                WHERE posts.id =  :id';

            $resultSet = $conn->executeQuery($sql, ['id' => $id]);
            return $resultSet->fetchAllAssociative();
            }
        
        //    /**
//     * @return Posts[] Returns an array of Posts objects
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

//    public function findOneBySomeField($value): ?Posts
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

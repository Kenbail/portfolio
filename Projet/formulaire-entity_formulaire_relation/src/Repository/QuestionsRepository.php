<?php

namespace App\Repository;

use App\Entity\Questions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Questions>
 *
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questions::class);
    }

    public function findquestionsPaginer(int $page, int $limit = 5):array
    {
        $limit = abs($limit);
        $result = [];
        
        
        $query = $this->getEntityManager()->CreateQueryBuilder()
            ->select('q')
            ->from('App\Entity\Questions','q')
            ->setMaxResults($limit)
            ->setFirstResult(($page *  $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();
        
        //Vérification si il y'a des données 
        if(empty($data)){
            return $result;
        }

       // calcul nombre de page
       $pages = ceil($paginator->count() / $limit);

       // remplir le tableau
       $result['data'] = $data;
       $result['pages'] = $pages;
       $result['pageact'] = $page;
       $result['limit'] = $limit;

        return $result;
    }
//    /**
//     * @return Questions[] Returns an array of Questions objects
//     */
//    public function ExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Questions
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

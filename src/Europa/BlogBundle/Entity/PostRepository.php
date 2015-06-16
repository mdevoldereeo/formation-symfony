<?php

namespace Europa\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * 
     * @param integer $id
     * @return array
     */
    public function find($id)
    {
        return $this->getEntityManager()->createQuery
        ('
          SELECT p, a FROM EuropaBlogBundle:Post p 
          JOIN p.author a
          WHERE p.id = :id 
        ')
        ->setParameters(array('id' => $id))
        ->getOneOrNullResult();
        
    }
    
    
    /**
     * 
     * @param integer $month
     * @param integer $year
     * @return array
     */
    public function findByMonth($month, $year = null)
    {
        $year = $year?: (new \DateTime())->format('Y');
        
        $startDate = (new \DateTime())->setDate($year, $month, 1);
        $endDate   = (new \DateTime())->setDate($year, $month+1, 1);
        
        return $this->getEntityManager()->createQuery
        ('
          SELECT p, a FROM EuropaBlogBundle:Post p 
          JOIN p.author a
          WHERE p.publishedate > :start 
          AND p.publishedate < :end 
        ')
        ->setParameters(array('start' => $startDate, 'end' => $endDate))
        ->getResult();
        
    }
    
    /**
     * @param string $needle
     */
    public function findByKeyword($needle, $loadAuthor = false)
    {
        $qb = $this->createQueryBuilder('p');
          
        if(true === $loadAuthor)
            $this->joinAuthor($qb);
         
        $qb->where('p.title LIKE :pattern')
            ->orderBy('p.publishedate', 'DESC')
            ->getQuery()
            ->setParameter('pattern', '%'.$needle.'%')
            ->getResult();
    }
    
    private function joinAuthor(\Doctrine\ORM\QueryBuilder $qb)
    {
        $qb->addSelect('a')->join('p.author', 'a');
    }
    
}

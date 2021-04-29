<?php

namespace App\Repository;

use App\Entity\Suggestions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Suggestions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suggestions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suggestions[]    findAll()
 * @method Suggestions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suggestions::class);
    }


    public function finBylistOrder ()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.type', 'ASC')
            ->getQuery()->getResult();
    }

    /**
    //  * @return Suggestions[] Returns an array of Suggestions objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.type = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findMY(int $id,String $d): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM suggestion s
            WHERE s.participant_id= :id
            and s.type=:d 
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id , 'd'=>$d]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }


}

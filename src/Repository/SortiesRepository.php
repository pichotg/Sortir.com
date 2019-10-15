<?php


namespace App\Repository;

use App\Entity\Sorties;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SortiesRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     * @return Sorties[]
     */
    public function findAllFilter(Array $data)
    {
        $qb = $this->createQueryBuilder('j')
            ->andWhere('j.')
            ->andWhere('j.lieu = :lieu')
            ->setParameter('lieu', $data['lieu']);

        $qb = $qb->getQuery();
        return $qb->execute();
    }

}
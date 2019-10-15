<?php


namespace App\Repository;

use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;

class SortiesRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     * @return Sorties[]
     */
    public function findAllFilter(
        Participants $loguser,
        Lieux $formLieu = null,
        bool $ownorganisateur = false ,
        DateTime $start = null,
        DateTime $stop = null,
        bool $subscibed = false,
        bool $unsubscribed= false,
        bool $passed = false)
    {
        $qb = $this->createQueryBuilder('s');
        if ($formLieu != null){
            $qb ->andWhere('s.lieu = :lieu')
                ->setParameter('lieu', $formLieu->getId());
        }
        if ($start != null){
            $qb ->andWhere('s.datedebut >= :datedebut')
                ->setParameter('datedebut', $start);
        }
        if ($stop != null){
            $qb ->andWhere('s.datecloture <= :datecloture')
                ->setParameter('datecloture', $stop);
        }
        if ($passed){
            $qb ->andWhere('s.datedebut <= :passed')
                ->setParameter('passed', date('Y-m-d H:i:s') );
        }
        if ($ownorganisateur){
            $qb ->andWhere('s.organisateur = :organisateur')
                ->setParameter('organisateur', $loguser->getId());
        }


        $qb = $qb->getQuery();
        return $qb->execute();
    }

}
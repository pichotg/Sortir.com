<?php

namespace App\DataFixtures;

use App\Entity\Sorties;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SortiesFixtures extends Fixture implements DependentFixtureInterface
{

    public const SORTIE_REFERENCE = 'sortie';

    public function load(ObjectManager $manager)
    {
        $sortie = new Sorties();
        $sortie->setNom("Conférence Symfony");
        $sortie->setCampus($this->getReference(CampusFixtures::USER_CAMPUS_REFERENCE));
        $sortie->setEtatsortie('Ouvert');
        $sortie->setDuree(4);
        $sortie->setDatedebut(new \DateTime('now'));
        $sortie->setDatecloture(date_add(new \DateTime('now'),date_interval_create_from_date_string('-1 days')));
        $sortie->setDescriptioninfos("Conférence sur les bases de Symfony 4.");
        $sortie->setLieu($this->getReference(LieuxFixtures::LIEUX_REFERENCE));
        $sortie->setNbinscriptionsmax(20);
        $sortie->setOrganisateur($this->getReference(UserFixtures::USER_REFERENCE));

        $manager->persist($sortie);
        $manager->flush();

        $this->addReference(self::SORTIE_REFERENCE, $sortie);
    }

    public function getDependencies()
    {
        return array(
            CampusFixtures::class,
            LieuxFixtures::class,
            UserFixtures::class
        );
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Inscriptions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InscriptionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $inscription = new Inscriptions();
        $inscription->setSortie($this->getReference(SortiesFixtures::SORTIE_REFERENCE));
        $inscription->setPartificpant($this->getReference(UserFixtures::USER_REFERENCE));
        $inscription->setDateInscription(new \DateTime("now"));
        $manager->persist($inscription);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SortiesFixtures::class,
            UserFixtures::class
        );
    }
}

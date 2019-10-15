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
        $inscription->setParticipant($this->getReference(UserFixtures::USER_REFERENCE));
        $inscription->setDateInscription(new \DateTime("now"));

        $manager->persist($inscription);
        $manager->flush();

        $sortie = $this->getReference(SortiesFixtures::SORTIE_REFERENCE);
        $user = $this->getReference(UserFixtures::USER_REFERENCE);

        $sortie->setInscriptions($inscription);
        $user->setInscriptions($inscription);
    }

    public function getDependencies()
    {
        return array(
            SortiesFixtures::class,
            UserFixtures::class
        );
    }
}

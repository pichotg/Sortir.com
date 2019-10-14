<?php

namespace App\DataFixtures;

use App\Entity\Lieux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LieuxFixtures extends Fixture implements DependentFixtureInterface
{

    public const LIEUX_REFERENCE = "lieux";

    public function load(ObjectManager $manager)
    {
        $lieux = new Lieux();
        $lieux->setNomLieu('Cobalt');
        $lieux->setRue('rue Victor Hugo');
        $lieux->setLatitude(46.580721);
        $lieux->setLongitude(0.337723);
        $lieux->setVille($this->getReference(VilleFixtures::VILLE1_REFERENCE));
        $manager->persist($lieux);

        $this->addReference(self::LIEUX_REFERENCE, $lieux);

        $lieux = new Lieux();
        $lieux->setNomLieu('ENI');
        $lieux->setRue('avenue Léo Lagrange');
        $lieux->setLatitude(46.316412);
        $lieux->setLongitude(-0.471082);
        $lieux->setVille($this->getReference(VilleFixtures::VILLE2_REFERENCE));
        $manager->persist($lieux);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            VilleFixtures::class,
        );
    }
}

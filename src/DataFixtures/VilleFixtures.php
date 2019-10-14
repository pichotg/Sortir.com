<?php

namespace App\DataFixtures;

use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{

    public const VILLE1_REFERENCE = 'ville1';
    public const VILLE2_REFERENCE = 'ville2';

    public function load(ObjectManager $manager)
    {
        $ville = new Villes();
        $ville->setNomVille('Poitiers');
        $ville->setCodePostal('86000');
        $manager->persist($ville);
        $manager->flush();

        $this->addReference(self::VILLE1_REFERENCE, $ville);

        $ville = new Villes();
        $ville->setNomVille('Niort');
        $ville->setCodePostal('79000');
        $manager->persist($ville);
        $manager->flush();

        $this->addReference(self::VILLE2_REFERENCE, $ville);
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{

    public const ADMIN_CAMPUS_REFERENCE = 'admin-campus';
    public const USER_CAMPUS_REFERENCE = 'user-campus';

    public function load(ObjectManager $manager)
    {
        $campus = new Campus();
        $campus->setNomCampus('Université de Poitiers');
        $manager->persist($campus);

        $this->addReference(self::USER_CAMPUS_REFERENCE, $campus);

        $campus = new Campus();
        $campus->setNomCampus('ENI');
        $manager->persist($campus);
        $manager->flush();

        $this->addReference(self::ADMIN_CAMPUS_REFERENCE, $campus);
    }
}

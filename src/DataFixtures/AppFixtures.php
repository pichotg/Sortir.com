<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Participants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * AppFixtures constructor.
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->_encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

    }
}

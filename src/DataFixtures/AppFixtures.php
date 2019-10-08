<?php

namespace App\DataFixtures;

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
        $participant = new Participants();
        $participant->setActif(true);
        $participant->setRoles(['ROLE_ADMIN']);
        $participant->setPseudo('admin');
        $participant->setPrenom('Admin');
        $participant->setNom('');
        $participant->setMail('admin@sortir.com');
        $participant->setMotDePasse($this->_encoder->encodePassword($participant, 'admin'));
        $participant->setTelephone(null);

        $manager->persist($participant);
        $manager->flush();
    }
}

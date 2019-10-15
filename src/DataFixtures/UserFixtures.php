<?php

namespace App\DataFixtures;

use App\Entity\Participants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $_encoder;
    public const ADMIN_REFERENCE = 'admin-user';
    public const USER_REFERENCE = 'user';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->_encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Participants();
        $user->setActif(true);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPseudo('admin');
        $user->setPrenom('Admin');
        $user->setNom('Admin');
        $user->setMail('admin@sortir.com');
        $user->setTelephone('0000000000');
        $user->setMotDePasse($this->_encoder->encodePassword($user, 'admin'));
        $user->setCampus($this->getReference(CampusFixtures::ADMIN_CAMPUS_REFERENCE));

        $manager->persist($user);

        $this->addReference(self::ADMIN_REFERENCE, $user);

        $user = new Participants();
        $user->setActif(true);
        $user->setRoles(['ROLE_USER']);
        $user->setPseudo('user');
        $user->setPrenom('John');
        $user->setNom('Doe');
        $user->setMail('johndoe@gmail.com');
        $user->setMotDePasse($this->_encoder->encodePassword($user, 'user'));
        $user->setTelephone('0000000000');
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS_REFERENCE));
        $manager->persist($user);

        $this->addReference(self::USER_REFERENCE, $user);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            CampusFixtures::class,
        );
    }
}

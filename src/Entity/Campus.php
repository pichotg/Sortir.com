<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campus
 *
 * @ORM\Table(name="campus")
 * @ORM\Entity
 */
class Campus
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_campus", type="string", length=30, nullable=false)
     */
    private $nomCampus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participants", mappedBy="campus")
     * @ORM\JoinColumn(name="Participants", referencedColumnName="id")
     */
    private $listParticipants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sorties", mappedBy="campus")
     * @ORM\JoinColumn(name="Participants", referencedColumnName="id")
     */
    private $listSorties;


}

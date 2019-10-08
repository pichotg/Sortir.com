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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNomCampus(): string
    {
        return $this->nomCampus;
    }

    /**
     * @param string $nomCampus
     */
    public function setNomCampus(string $nomCampus): void
    {
        $this->nomCampus = $nomCampus;
    }

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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscriptions
 *
 * @ORM\Table(name="inscriptions")
 * @ORM\Entity
 */
class Inscriptions
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Sorties", inversedBy="inscriptions")
     * @ORM\JoinColumn(name="sortie_id", referencedColumnName="id", nullable=false)
     */
    private $sortie;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Participants", inversedBy="inscriptions")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="id", nullable=false)
     */
    private $partificpant;

    /**
     * @ORM\Column(name="date_inscription", type="datetime", nullable=false)
     */
    private $dateInscription;

    /**
     * @return mixed
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param mixed $sortie
     */
    public function setSortie($sortie): void
    {
        $this->sortie = $sortie;
    }

    /**
     * @return mixed
     */
    public function getPartificpant()
    {
        return $this->partificpant;
    }

    /**
     * @param mixed $partificpant
     */
    public function setPartificpant($partificpant): void
    {
        $this->partificpant = $partificpant;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * @param mixed $dateInscription
     */
    public function setDateInscription($dateInscription): void
    {
        $this->dateInscription = $dateInscription;
    }

}

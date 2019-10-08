<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sorties
 *
 * @ORM\Table(name="sorties", indexes={@ORM\Index(name="sorties_lieux_fk", columns={"lieux_no_lieu"}), @ORM\Index(name="sorties_participants_fk", columns={"organisateur"}), @ORM\Index(name="sorties_etats_fk", columns={"etats_no_etat"})})
 * @ORM\Entity
 */
class Sorties
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_sortie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime", nullable=false)
     */
    private $datedebut;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecloture", type="datetime", nullable=false)
     */
    private $datecloture;

    /**
     * @var int
     *
     * @ORM\Column(name="nbinscriptionsmax", type="integer", nullable=false)
     */
    private $nbinscriptionsmax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptioninfos", type="string", length=500, nullable=true)
     */
    private $descriptioninfos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etats", inversedBy="sorties")
     * @ORM\JoinColumn(name="Etats", referencedColumnName="id")
     */
    private $etatsortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participants", inversedBy="")
     * @ORM\JoinColumn(name="Participants", referencedColumnName="id")
     */
    private $organisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sorties", inversedBy="lieu")
     * @ORM\JoinColumn(name="Sorties", referencedColumnName="id")
     */
    private $lieu;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="sorties")
     * @ORM\JoinColumn(name="Campus", referencedColumnName="id")
     */
    private $campus;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Participants", inversedBy="listSorties")
     * @ORM\JoinColumn(name="Participants", referencedColumnName="id")
     */
    private $listParticipants;

}

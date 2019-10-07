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
     * @var int|null
     *
     * @ORM\Column(name="etatsortie", type="integer", nullable=true)
     */
    private $etatsortie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @var int
     *
     * @ORM\Column(name="organisateur", type="integer", nullable=false)
     */
    private $organisateur;

    /**
     * @var int
     *
     * @ORM\Column(name="lieux_no_lieu", type="integer", nullable=false)
     */
    private $lieuxNoLieu;

    /**
     * @var int
     *
     * @ORM\Column(name="etats_no_etat", type="integer", nullable=false)
     */
    private $etatsNoEtat;


}

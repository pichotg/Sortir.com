<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sorties
 *
 * @ORM\Table(name="sorties")
 * @ORM\Entity
 */
class Sorties
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
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime", nullable=true)
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
     * @ORM\Column(name="datecloture", type="datetime", nullable=true)
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
     * @var String
     *
     * @ORM\Column(name="etat", type="string", nullable=false, length=500, columnDefinition="enum('En création', 'En cours', 'Ouvert', 'Fermé', 'Annulée')")
     */
    private $etatsortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participants", inversedBy="listOrganisateurSorties")
     * @ORM\JoinColumn(name="organisateur", referencedColumnName="id")
     */
    private $organisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux", inversedBy="listSorties")
     * @ORM\JoinColumn(name="Lieux", referencedColumnName="id")
     */
    private $lieu;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="listSorties")
     * @ORM\JoinColumn(name="Campus", referencedColumnName="id")
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscriptions", mappedBy="sortie")
     */
    private $inscriptions;


    /**
     * @return int
     */
    public function getId(): ?int
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
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return \DateTime
     */
    public function getDatedebut(): ?\DateTime
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime $datedebut
     */
    public function setDatedebut(\DateTime $datedebut): void
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return int|null
     */
    public function getDuree(): ?int
    {
        return $this->duree;
    }

    /**
     * @param int|null $duree
     */
    public function setDuree(?int $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return \DateTime
     */
    public function getDatecloture(): ?\DateTime
    {
        return $this->datecloture;
    }

    /**
     * @param \DateTime $datecloture
     */
    public function setDatecloture(\DateTime $datecloture): void
    {
        $this->datecloture = $datecloture;
    }

    /**
     * @return int
     */
    public function getNbinscriptionsmax(): ?int
    {
        return $this->nbinscriptionsmax;
    }

    /**
     * @param int $nbinscriptionsmax
     */
    public function setNbinscriptionsmax(int $nbinscriptionsmax): void
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;
    }

    /**
     * @return string|null
     */
    public function getDescriptioninfos(): ?string
    {
        return $this->descriptioninfos;
    }

    /**
     * @param string|null $descriptioninfos
     */
    public function setDescriptioninfos(?string $descriptioninfos): void
    {
        $this->descriptioninfos = $descriptioninfos;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     */
    public function setOrganisateur($organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus): void
    {
        $this->campus = $campus;
    }

    /**
     * @return string
     */
    public function getEtatsortie(): ?string
    {
        return $this->etatsortie;
    }

    /**
     * @param string $etatsortie
     */
    public function setEtatsortie(string $etatsortie): void
    {
        $this->etatsortie = $etatsortie;
    }

    /**
     * @return mixed
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * @param mixed $inscriptions
     */
    public function setInscriptions($inscriptions): void
    {
        $this->inscriptions = $inscriptions;
    }

}

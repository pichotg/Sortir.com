<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieux
 *
 * @ORM\Table(name="lieux", indexes={@ORM\Index(name="lieux_villes_fk", columns={"villes_no_ville"})})
 * @ORM\Entity
 */
class Lieux
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_lieu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noLieu;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lieu", type="string", length=30, nullable=false)
     */
    private $nomLieu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=30, nullable=true)
     */
    private $rue;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var int
     *
     * @ORM\Column(name="villes_no_ville", type="integer", nullable=false)
     */
    private $villesNoVille;


}

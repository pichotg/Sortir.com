<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Villes
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity
 */
class Villes
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_ville", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noVille;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ville", type="string", length=30, nullable=false)
     */
    private $nomVille;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=10, nullable=false)
     */
    private $codePostal;


}

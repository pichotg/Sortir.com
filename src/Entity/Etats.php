<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etats
 *
 * @ORM\Table(name="etats")
 * @ORM\Entity
 */
class Etats
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_etat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noEtat;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=30, nullable=false)
     */
    private $libelle;


}

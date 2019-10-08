<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VillesController extends AbstractController
{
    /**
     * @Route("/villes", name="villes")
     */
    public function index()
    {
        return $this->render('villes/index.html.twig', [
            'controller_name' => 'VillesController',
        ]);
    }
}

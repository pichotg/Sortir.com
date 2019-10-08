<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EtatsController extends AbstractController
{
    /**
     * @Route("/etats", name="etats")
     */
    public function index()
    {
        return $this->render('etats/index.html.twig', [
            'controller_name' => 'EtatsController',
        ]);
    }
}

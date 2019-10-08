<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionsController extends AbstractController
{
    /**
     * @Route("/inscriptions", name="inscriptions")
     */
    public function index()
    {
        return $this->render('inscriptions/index.html.twig', [
            'controller_name' => 'InscriptionsController',
        ]);
    }
}

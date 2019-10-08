<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LieuxController extends AbstractController
{
    /**
     * @Route("/lieux", name="lieux")
     */
    public function index()
    {
        return $this->render('lieux/index.html.twig', [
            'controller_name' => 'LieuxController',
        ]);
    }
}

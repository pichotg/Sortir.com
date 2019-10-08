<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    /**
     * @Route("/campus", name="campus")
     */
    public function index()
    {
        return $this->render('campus/index.html.twig', [
            'controller_name' => 'CampusController',
        ]);
    }
}

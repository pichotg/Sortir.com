<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sorties;
use App\Form\SortiesType;

class SortiesController extends AbstractController
{

    private $sortiesListe = null;
    /**
     * @Route("/sorties", name="sorties")
     */
    public function index( EntityManagerInterface $em)
    {
        $this->sortiesListe = $em->getRepository(Sorties::class)->findAll();
        return $this->render('sorties/index.html.twig', [
            'controller_name' => 'SortiesController',
            'sorties' => $this->sortiesListe,
            'page_name' => "Sorties"
        ]);
    }


    /**
     * @Route("/sorties/edit/{id}", name="edit_sortie")
     */
    public function edit(Sorties $sortie, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(SortiesType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $sortie = $form->getData();

            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Sortie successfully modified !');

            $this->sortiesListe = $em->getRepository(Sorties::class)->findAll();

            return $this->redirectToRoute('sorties');
        }

        return $this->render('sorties/edit.html.twig', [
            'page_name' => 'Sortie Edit',
            'sortie' => $sortie,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/sorties/{id}", name="afficher_sortie")
     */
    public function afficher(Sorties $sortie, Request $request, EntityManagerInterface $em)
    {
        $sortieData = $this->sortiesListe = $em->getRepository(Sorties::class)->find($request->get('id'));
        return $this->render('sorties/afficher.html.twig', [
            'page_name' => 'Afficher Sortie',
            'sortie' => $sortieData
        ]);
    }
}

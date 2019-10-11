<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Form\LieuxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LieuxController extends AbstractController
{
    private $lieuxListe = null;

    /**
     * @Route("/lieux", name="lieux")
     */
    public function list(Request $request, EntityManagerInterface $em)
    {
        $this->lieuxListe = $em->getRepository(Lieux::class)->findAll();

        dump($this->lieuxListe);

        return $this->render('Lieux/index.html.twig', [
            'page_name' => 'Lieux',
            'lieux' => $this-> lieuxListe
        ]);
    }

    /**
     * @Route("/lieu/add" , name="add_lieu")
     */
    public function add(Request $request, EntityManagerInterface $em){
        $lieu = new Lieux();
        $form = $this->createForm(LieuxType::class, $lieu);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lieu = $form->getData();
            $em->persist($lieu);
            $em->flush();
            $this->addFlash('success', 'Lieux successfully added !');
            return $this->redirectToRoute('lieux');
        }

        return $this->render('Lieux/add.html.twig', [
            'page_name' => 'lieu Add',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/lieu/{id}", name="edit_lieu")
     */
    public function edit(Lieux $lieu, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(LieuxType::class, $lieu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $lieu = $form->getData();

            $em->persist($lieu);
            $em->flush();
            $this->addFlash('success', 'lieu successfully modified !');

            $this->lieuxListe = $em->getRepository(Lieux::class)->findAll();

            return $this->redirectToRoute('lieux');
        }

        return $this->render('lieux/edit.html.twig', [
            'page_name' => 'lieu Edit',
            'lieu' => $lieu,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/lieu/delete/{id}", name="delete_lieu" , requirements={"id"="\d+"})
     */
    public function delete(Lieux $lieu, Request $request, EntityManagerInterface $em)
    {
        $lieu = $em->getRepository(Lieux::class)->find($request->get('id'));

        $em->remove($lieu);
        $em->flush();
        $this->addFlash('success', 'lieu was deleted !');

        return $this->redirectToRoute('lieux');
    }
}

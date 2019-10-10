<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    private $campusListe = null;

    /**
     * @Route("/campus", name="campus")
     */
    public function list(Request $request, EntityManagerInterface $em)
    {
        $this->campusListe = $em->getRepository(Campus::class)->findAll();

        dump($this->campusListe);

        return $this->render('campus/index.html.twig', [
            'page_name' => 'campus',
            'campus' => $this->campusListe
        ]);
    }

    /**
     * @Route("/campus/add" , name="add_campus")
     */
    public function add(Request $request, EntityManagerInterface $em){
        $campus = new Campus();
        $form = $this->createForm(CampusType::class, $campus);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campus = $form->getData();
            $em->persist($campus);
            $em->flush();
            $this->addFlash('success', 'campus successfully added !');
            return $this->redirectToRoute('campus');
        }

        return $this->render('campus/add.html.twig', [
            'page_name' => 'campus Add',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/campus/{id}", name="edit_campus")
     */
    public function edit(campus $campus, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(campusType::class, $campus);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $campus = $form->getData();

            $em->persist($campus);
            $em->flush();
            $this->addFlash('success', 'campus successfully modified !');

            $this->campusListe = $em->getRepository(campus::class)->findAll();

            return $this->redirectToRoute('campus');
        }

        return $this->render('campus/edit.html.twig', [
            'page_name' => 'campus Edit',
            'campus' => $campus,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/campus/delete/{id}", name="delete_campus" , requirements={"id"="\d+"})
     */
    public function delete(campus $campus, Request $request, EntityManagerInterface $em)
    {
        $campus = $em->getRepository(campus::class)->find($request->get('id'));

        $em->remove($campus);
        $em->flush();
        $this->addFlash('success', 'campus was deleted !');

        return $this->redirectToRoute('campus');
    }
}

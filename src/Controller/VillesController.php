<?php

namespace App\Controller;

use App\Entity\Villes;
use App\Form\VillesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VillesController extends AbstractController
{
    private $villesListe = null;

    /**
     * @Route("/villes", name="villes")
     */
    public function list(Request $request, EntityManagerInterface $em)
    {
        $this->villesListe = $em->getRepository(Villes::class)->findAll();

        dump($this->villesListe);

        return $this->render('villes/index.html.twig', [
            'page_name' => 'Villes',
            'villes' => $this-> villesListe
        ]);
    }

    /**
     * @Route("/ville/add" , name="add_ville")
     */
    public function add(Request $request, EntityManagerInterface $em){
        $ville = new Villes();
        $form = $this->createForm(VillesType::class, $ville);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ville = $form->getData();
            $em->persist($ville);
            $em->flush();
            $this->addFlash('success', 'Villes successfully added !');
            return $this->redirectToRoute('villes');
        }
        return $this->render('villes/add.html.twig', [
            'page_name' => 'Ville Add',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ville/{id}", name="edit_ville")
     */
    public function edit(Villes $ville, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VillesType::classType, $ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $genre = $form->getData();

            $em->persist($ville);
            $em->flush();
            $this->addFlash('success', 'Ville successfully modified !');

            $this->villesListe = $em->getRepository(Villes::class)->findAll();

            return $this->redirectToRoute('villes');
        }

        return $this->render('ville/edit.html.twig', [
            'page_name' => 'Ville Edit',
            'ville' => $ville,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/genre/delete/{id}", name="delete_genre" , requirements={"id"="\d+"})
     */
    public function delete(Villes $ville, Request $request, EntityManagerInterface $em)
    {
        $ville = $em->getRepository(Villes::class)->find($request->get('id'));

        $em->remove($ville);
        $em->flush();
        $this->addFlash('success', 'Ville was deleted !');

        return $this->redirectToRoute('villes');
    }


}

<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Form\SortiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;

class SortiesController extends AbstractController
{

    private $sortiesListe = null;
    /**
     * @Route("/sorties", name="sorties")
     */
    public function index( EntityManagerInterface $em)
    {
        $this->sortiesListe = $em->getRepository(Sorties::class)->findAll();
        dump($this->sortiesListe);
        return $this->render('sorties/index.html.twig', [
            'controller_name' => 'SortiesController',
            'sorties' => $this->sortiesListe,
            'page_name' => "Sorties"
        ]);
    }

    /**
     * @Route("/sorties/add", name="sortie_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $sortie = new Sorties();

        $form = $this->createForm(SortiesType::class, $sortie);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortie = $form->getData();
            $sortie->setEtatSortie("Ouvert");
            $sortie->setOrganisateur($this->getUser());

            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Sortie successfully added !');
            return $this->redirectToRoute('sorties');
        }

        return $this->render('sorties/add.html.twig', [
            'page_name' => 'Sortie Add',
            'form' => $form->createView()
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

    /**
     * @Route("/sorties/addParticipant/{id}", name="add_participant_sortie")
     */
    public function add_participant(EntityManagerInterface $em, Request $request){


        $sortie = $em->getRepository(Sorties::class)->find($request->get('id'));
        dump($sortie);
        $inscription = new Inscriptions();
        $participant = $this->getUser();
        $inscription->setDateInscription(new \DateTime());
        $inscription->setSortie($sortie);
        $inscription->setParticipant($participant);

        $em->persist($inscription);


        $em->flush();
        return $this->redirectToRoute('sorties');
    }

    /**
     * @Route("/sorties/removeParticipant/{id}", name="remove_participant_sortie")
     */
    public function remove_participant(EntityManagerInterface $em, Request $request, Inscriptions $inscription){

        $participant = $this->getUser();

        $sortie = $em->getRepository(Sorties::class)->find($request->get('id'));

        $inscription = $em->getRepository(Inscriptions::class)->findBy(['sortie'=>$sortie->getId(), 'participant'=>$participant->getId()],['sortie'=>'ASC']);
        dump($inscription);
        $inscriptionRemove = new Inscriptions();

        $inscriptionRemove->setSortie($inscription[0]->getSortie());
        $inscriptionRemove->setParticipant($inscription[0]->getParticipant());
        $inscriptionRemove->setDateInscription($inscription[0]->getDateInscription());
        dump($inscriptionRemove);
        $em->remove($inscriptionRemove);
        $em->flush();

        return $this->redirectToRoute('sorties');
    }

}

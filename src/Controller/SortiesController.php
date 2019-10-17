<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Form\AnnulerSortieType;
use App\Form\FilterType;
use App\Form\SortiesType;
use App\Repository\SortiesRepository;
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
    public function index(Request $request, SortiesRepository $sr, EntityManagerInterface $em)
    {
        $sortiesListe = null;
        $form = $this->createForm(FilterType::class);

        $form->handleRequest($request);
        $subscibed = null;
        $unsubscribed = null;
        if ($form->isSubmitted() && $form->isValid()) {

            $lieu = $form['lieu']->getData();


            $start = $form['start']->getData();
            $close = $form['close']->getData();

            $ownorganisateur = $form['ownorganisateur']->getData();

            $subscibed = $form['subscibed']->getData();
            $unsubscribed = $form['unsubscribed']->getData();
            $passed = $form['passed']->getData();
            $participant = $em->getRepository(Participants::class)->find($this->getUser()->getId());
            $this->sortiesListe = $sr->findAllFilter($participant, $lieu,$ownorganisateur , $start, $close, $passed);
        }else{
            $this->sortiesListe = $em->getRepository(Sorties::class)->findAll();
        }
        // dump( $this->sortiesListe);

        return $this->render('sorties/index.html.twig', [
            'unsubscribed' => $unsubscribed,
            'subscibed' => $subscibed,
            'app_name' => 'Evenements',
            'form' => $form->createView(),
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
            if( $form->get('Send')->isClicked()){
                $sortie->setEtatSortie("En création");
            }elseif( $form->get('Publish')->isClicked()){
                $sortie->setEtatSortie("Ouvert");
            }else{
                return $this->redirectToRoute('sorties');
            }

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

            if( $form->get('Send')->isClicked()){
                $sortie->setEtatSortie("En création");
            }elseif( $form->get('Publish')->isClicked()){
                $sortie->setEtatSortie("Ouvert");
            }else{
                return $this->redirectToRoute('sorties');
            }

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
        $participants = $em->getRepository(Inscriptions::class)->findBy(['sortie'=>$request->get('id')]);
        dump($sortieData);
        return $this->render('sorties/afficher.html.twig', [
            'page_name' => 'Description Sortie',
            'sortie' => $sortieData,
            'participants' => $participants
        ]);
    }

    /**
     * @Route("/sorties/addParticipant/{id}", name="add_participant_sortie")
     */
    public function add_participant(EntityManagerInterface $em, Request $request, Sorties $sortie){

        $participant = $em->getRepository(Participants::class)->find($this->getUser()->getId());
        $inscription = new Inscriptions();
        $inscription->setDateInscription(new \DateTime());
        $inscription->setSortie($sortie);
        $inscription->setParticipant($participant);

        $em->persist($inscription);


        $em->flush();
        $this->addFlash('success', 'Inscription successfully done !');
        return $this->redirectToRoute('sorties');
    }

    /**
     * @Route("/sorties/removeParticipant/{id}", name="remove_participant_sortie")
     */
    public function remove_participant(EntityManagerInterface $em, Request $request){
        dump($request->get('id'));
        $participant = $this->getUser();

        $sortie = $em->getRepository(Sorties::class)->find($request->get('id'));

        $inscription = $em->getRepository(Inscriptions::class)->findBy(['sortie'=>$sortie->getId(), 'participant'=>$participant->getId()],['sortie'=>'ASC']);
        dump($inscription);
        $em->remove($inscription[0]);
        $em->flush();
        $this->addFlash('success', 'Inscription successfully remove !');
        return $this->redirectToRoute('sorties');
    }

    /**
     * @Route("/sorties/annuler/{id}", name="annuler_sortie")
     */
    public function annuler_sortie(Request $request, EntityManagerInterface $em, Sorties $sortie){

        $participant = $this->getUser();

        $form = $this->createForm(AnnulerSortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            dump($form['descriptioninfos']->getData());
            $sortie->setDescriptioninfos($form['descriptioninfos']->getData());
            $sortie->setEtatsortie("Annulée");

            $em->flush();
            $this->addFlash('success', 'Sortie successfully canceled !');

            $this->sortiesListe = $em->getRepository(Sorties::class)->findAll();
            $this->addFlash('success', 'Inscription successfully remove !');
            return $this->redirectToRoute('sorties');

        }



        return $this->render('sorties/annuler.html.twig', [
            'page_name' => 'Annuler Sortie',
            'sortie' => $sortie,
            'participants' => $participant,
            'form' => $form->createView()
        ]);
    }

}

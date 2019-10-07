<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantsController extends AbstractController
{
    /**
     * @Route("/participants", name="participants")
     */
    public function index()
    {
        return $this->render('participants/index.html.twig', [
            'controller_name' => 'ParticipantsController',
        ]);
    }

    /**
     * @Route("/participants/add", name="add_participants")
     */
    public function addParticipants(Request $request,UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em){
        $participant = new Participants();

        $formParticipant =$this->createForm(ParticipantsType::class);

        $formParticipant->handleRequest($request);

        if($formParticipant->isSubmitted() && $formParticipant->isValid()){
            $participant = $formParticipant->getData();

            $password = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($password);

            // set user profile photo
            $filePhoto = $formParticipant['photo']->getData();
            if($filePhoto){
                $originalFilename = pathinfo($filePhoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $filePhoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $filePhoto->move(
                        '../public/files/photo',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $participant->setPhoto($newFilename);
            }


            $em->persist($participant);
            $em->flush();
            $this->addFlash('success','Participants successfully added');
            return $this->redirectToRoute('main');
        }

        return $this->render('participants/add_participants.html.twig',[
            'page_name' => 'Registration',
            'formParticipant'=>$formParticipant->createView(),
        ]);

    }

}

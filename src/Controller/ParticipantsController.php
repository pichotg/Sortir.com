<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ParticipantsController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('participants/login.html.twig', [
            'page_name' => 'Connexion',
            'last_username'=>$lastUsername,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/participants/add", name="add_participants")
     */
    public function addParticipants(Request $request,UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em){
        $participant = new Participants();

        $formParticipant =$this->createForm(ParticipantsType::class);

        $formParticipant->handleRequest($request);

        if($formParticipant->isSubmitted() && $formParticipant->isValid()){
            $participant = new Participants();
            $participant = $formParticipant->getData();

            $password = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setMotDePasse($password);
            $participant->setRoles(['ROLE_USER']);
            $participant->setActif(1);

            $participant = $this->uploadFile($formParticipant['photo']->getData(), $participant);

            $em->persist($participant);
            $em->flush();
            $this->addFlash('success','Vous êtes inscrit !');
            return $this->redirectToRoute('home');
        }

        return $this->render('participants/add_participants.html.twig',[
            'page_name' => 'Inscription',
            'formParticipant'=>$formParticipant->createView(),
        ]);

    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil()
    {
        return $this->render('participants/profil.html.twig', [
            'edit' => false,
            'form' => null,
            'page_name' => 'Profil'
        ]);
    }

    /**
     * @Route("/profil/edit", name="profil_edit")
     */
    public function profil_edit(Request $request, EntityManagerInterface $em)
    {
        $participant = new Participants();
        $participant = $this->getUser();

        $form = $this->createForm(ParticipantsType::class, $participant);
        $form->remove('motDePasse')
             ->remove('campus')
             ->remove('photo');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $participant = new Participants();
            $participant = $form->getData();

            /**
             * Edit profil pic : not working yet
             *
             * if(false){
             *   $participant = $this->uploadFile($form['photo']->getData(), $participant);
             * }
             */


            $em->persist($participant);
            $em->flush();
            $this->addFlash('success','Le profil a été été mis à jour !');

            return $this->redirectToRoute('profil');
        }

        return $this->render('participants/profil.html.twig', [
            'edit' => true,
            'form' => $form->createView(),
            'page_name' => 'Profil'
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(EntityManagerInterface $em)
    {
        $users = $em->getRepository(Participants::class)->findAll();
        dump($users);

        return $this->render('participants/users.html.twig', [
            'users' => $users,
            'page_name' => 'Gestion Utilisateurs'
        ]);
    }

    private function uploadFile($file, $user){
        // Set User profile photo
        if($file){
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = 'profil' . '-' . uniqid() . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    '../public/files/photo',
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $user->setPhoto($newFilename);
        }
        return $user;
    }

}

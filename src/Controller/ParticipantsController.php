<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participants;
use App\Form\FilesType;
use App\Form\ParticipantsType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/reset_password", name="reset_password")
     */
    public function reset_password(Request $request, \Swift_Mailer $mailer, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new Participants();
        $form = $this->createForm(ParticipantsType::class, $user);
        $form->remove('pseudo')
            ->remove('nom')
            ->remove('prenom')
            ->remove('telephone')
            ->remove('campus')
            ->remove('motDePasse')
            ->remove('photo')
            ->remove('actif')
            ->remove('id')
            ->remove('submit');
        $form->add('submit',SubmitType::class, [
            'label' => 'Envoyer l\'email',
            'attr' => [
                'class' => 'btn btn-primary w-100'
            ]
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $mail = $form['mail']->getData();
            $user = $em->getRepository(Participants::class)->findOneByMail($mail);

            if(!is_null($user)){
                $message = new \Swift_Message();
                $message->setSubject("Changement de mot de passe")
                    ->setFrom("admin@sortir.com")
                    ->setTo($user->getMail())
                    ->setBody($this->renderView("mail/reset_password.html.twig", ["email" => $mail]), "text/html");
                $mailer->send($message);

                $this->addFlash('success', 'L\'email de réinitialisation du mot de passe à été envoyé à l\'adresse : ' . $mail);
                $this->redirectToRoute('home');
            } else {
                $this->addFlash('danger', 'Il n\'existe aucun compte avec l\'adresse mail : ' . $mail);
            }
        }

        return $this->render('participants/send_reset_password.html.twig', [
            'page_name' => 'Réinitialisation du mot de passe',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset_password/{email}", name="reset_password_email")
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, $email){
        $user = new Participants();
        $form = $this->createForm(ParticipantsType::class);
        $form->remove('id')
            ->remove('pseudo')
            ->remove('nom')
            ->remove('prenom')
            ->remove('telephone')
            ->remove('mail')
            ->remove('campus')
            ->remove('photo')
            ->remove('actif');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $userModif = $em->getRepository(Participants::class)->findOneByMail($email);

            $userModif->setPassword('');
            $password = $passwordEncoder->encodePassword($user, $form->getData()->getPassword());
            $userModif->setPassword($password);

            $em->persist($userModif);
            $em->flush();

            $this->addFlash('success','Votre mot de passe à été modifié !');

            return $this->redirectToRoute('home');
        }

        return $this->render('participants/reset_password.html.twig',[
            'page_name' => 'Réinitialiser le mot de passe',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/participants/add", name="add_participants")
     */
    public function addParticipants(Request $request,UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, FileUploader $fileUploader){
        $participant = new Participants();

        $formParticipant = $this->createForm(ParticipantsType::class);
        $formParticipant->remove('actif')
                        ->remove('id')
                        ->remove('submit');
        $formParticipant->add('submit',SubmitType::class, [
            'label' => 'S\'inscrire !',
            'attr' => [
                'class' => 'btn btn-success w-100'
            ]
        ]);

        $formParticipant->handleRequest($request);

        if($formParticipant->isSubmitted() && $formParticipant->isValid()){
            $participant = new Participants();
            $participant = $formParticipant->getData();

            $password = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setMotDePasse($password);
            $participant->setRoles(['ROLE_USER']);
            $participant->setActif(1);

            $file = $formParticipant['photo']->getData();
            if($file){
                $filename = $fileUploader->upload($file);
                $participant->setPhoto($filename);
            }

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
            'edit_password' => false,
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
            ->remove('photo')
            ->remove('actif')
            ->remove('submit');
        $form->add('submit',SubmitType::class, [
            'label' => 'Mettre à jour',
            'attr' => [
                'class' => 'btn btn-success w-100'
            ]
        ]);

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
            $this->addFlash('success','Le profil a été mis à jour !');

            return $this->redirectToRoute('profil');
        }

        return $this->render('participants/profil.html.twig', [
            'edit' => true,
            'edit_password' => false,
            'form' => $form->createView(),
            'page_name' => 'Profil'
        ]);
    }

    /**
     * @Route("/profil/edit_password", name="profil_edit_password")
     */
    public function profil_edit_password(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new Participants();
        $user = $this->getUser();

        $form = $this->createForm(ParticipantsType::class, $user);
        $form->remove('id')
            ->remove('pseudo')
            ->remove('nom')
            ->remove('prenom')
            ->remove('telephone')
            ->remove('mail')
            ->remove('campus')
            ->remove('photo')
            ->remove('actif')
            ->remove('submit');
        $form->add('submit',SubmitType::class, [
            'label' => 'Mettre à jour le mot de passe',
            'attr' => [
                'class' => 'btn btn-success w-100'
            ]
        ]);;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = new Participants();
            $user = $form->getData();

            $encoded_password = $encoder->encodePassword($user, $form['motDePasse']->getData());
            $user->setPassword($encoded_password);

            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Votre mot de passe a été mis à jour !');

            return $this->redirectToRoute('profil');
        }

        return $this->render('participants/profil.html.twig', [
            'edit' => false,
            'edit_password' => true,
            'form' => $form->createView(),
            'page_name' => 'Modification du mot de passe'
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(Request $request, EntityManagerInterface $em)
    {
        $user = new Participants();
        $form = $this->createForm(ParticipantsType::class, $user);
        $form->remove('photo')
            ->remove('motDePasse');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user_id = $form['id']->getData();
            $user = $em->getRepository(Participants::class)->findOneById($user_id);

            $user_new = new Participants();
            $user_new = $form->getData();

            $user->setPseudo($user_new->getPseudo());
            $user->setNom($user_new->getNom());
            $user->setPrenom($user_new->getPrenom());
            $user->setTelephone($user_new->getTelephone());
            $user->setMail($user_new->getMail());
            $user->setCampus($user_new->getCampus());
            $user->setActif($user_new->isActif());

            $em->persist($user);
            $em->flush();
            $this->addFlash('success','L\'utilisateur ' . $user->getPseudo() . ' a été été mis à jour !');
        }

        $users = $em->getRepository(Participants::class)->findAll();

        return $this->render('participants/users.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
            'page_name' => 'Gestion Utilisateurs'
        ]);
    }

    /**
     * @Route("/users/delete", name="delete_users")
     */
    public function delete_users(Request $request, EntityManagerInterface $em)
    {
        $user_id = $request->request->get('participants')['id'];
        if($this->getUser()->getId() != $user_id){
            $user = new Participants();
            $user = $em->getRepository(Participants::class)->findOneById($user_id);
            $user_pseudo = $user->getPseudo();
            if(sizeof($user->getListOrganisateurSorties()) == 0){
                $em->remove($user);
                $em->flush();

                $this->addFlash('success','L\'utilisateur ' . $user_pseudo . ' a été été mis à jour !');
            }
            $this->addFlash('danger','L\'utilisateur est l\'organisateur de un ou plusieurs événement.');
        } else {
            $this->addFlash('danger','Vous ne pouvez pas supprimer votre propre utilisateur.');
        }

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("/users/import", name="import_user")
     */
    public function import_user(Request $request, EntityManagerInterface $em, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(FilesType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $file = $form['file']->getData();
            if($file){
                $file = fopen($file, 'r');
                $data = [];

                while (($line = fgetcsv($file)) !== FALSE) {
                    array_push($data, $line[0]);
                }
                fclose($file);

                foreach ($data as $line){
                    $splited_line = explode(";",$line);
                    $splited_line[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $splited_line[0]);
                    if($splited_line[0] != 'pseudo'){
                        $user = new Participants();
                        $user->setPseudo($splited_line[0]);
                        $user->setNom($splited_line[1]);
                        $user->setPrenom($splited_line[2]);
                        $user->setTelephone($splited_line[3]);
                        $user->setMail($splited_line[4]);

                        $campus = $em->getRepository(Campus::class)->findOneBynomCampus($splited_line[5]);
                        if(is_null($campus)){
                            $campus = new Campus();
                            $campus->setNomCampus($splited_line[5]);
                            $em->persist($campus);
                        }
                        $user->setCampus($campus);

                        $encoded_password = $encoder->encodePassword($user, $splited_line[6]);
                        $user->setMotDePasse($encoded_password);

                        $user->setActif(true);

                        $em->persist($user);
                    }
                }

                $em->flush();
                $this->addFlash('success', 'L\'import c\'est biend déroulé !');

            } else {
                $this->addFlash('danger', 'Le fichier n\'a pas pu être ouvert.');
            }
        }

        return $this->render('participants/users.html.twig', [
            'page_name' => 'Import fichier CSV',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/add", name="users_add")
     */
    public function users_add(Request $request, EntityManagerInterface $em, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder)
    {
        $user = new Participants();

        $form = $this->createForm(ParticipantsType::class, $user);
        $form->remove('id');
        $form->add('role',ChoiceType::class, [
            'label' => 'Role utilisateur',
            "mapped" => false,
            'choices'  => [
                'Utilisateur' => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
            ],
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setMotDePasse($password);
            $role = $form['role']->getData();
            $role =  array(0 => $role);
            $user->setRoles($role);

            $file = $user->getPhoto();
            if($file){
                $filename = $fileUploader->upload($file);
                $user->setPhoto($filename);
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash('success','New user');
            return $this->redirectToRoute('home');
        }

        return $this->render('participants/users.html.twig',[
            'users' => null,
            'page_name' => 'Ajouter un utilisateurs',
            'form'=>$form->createView(),
        ]);
    }

    public function generateRandomString($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#@-_=$')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

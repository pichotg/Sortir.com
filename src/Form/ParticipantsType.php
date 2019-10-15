<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participants;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class, [
                'label' => 'ID',
                'attr' =>
                    [
                        'readonly' => true
                    ]
            ])
            ->add('pseudo', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('telephone', TextType::class)
            ->add('mail', TextType::class)
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom_campus',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nomCampus', 'ASC');
                }
            ])
            ->add('motDePasse', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passes doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo Image file (jpg, jpeg, png, gif)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/gif',
                            // jpg, jpeg, png, gif
                        ],
                        'mimeTypesMessage' => 'Please upload a valid vignette Media file',
                    ])
                ],
            ])
            ->add('actif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false
            ])
            ->add('submit',SubmitType::class, [
                'label' => 'Soumettre',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}

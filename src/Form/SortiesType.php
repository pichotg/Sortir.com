<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieux;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('datedebut',TextType::class,[
                'label'    => 'Date Evenement (début)',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle'=>'datetimepicker',
                    'data-target'=>'#sorties_datedebut'
                  ],
                'required'      => true,
                'mapped' => false
            ])
            ->add('duree',IntegerType::class)
            ->add('datecloture',TextType::class,[
                'label'    => 'Date Cloture inscription',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle'=>'datetimepicker',
                    'data-target'=>'#sorties_datecloture'
                  ],
                'required'      => true,
                'mapped' => false
            ])
            ->add('nbinscriptionsmax',IntegerType::class, [
                'label' => 'Nombre d\'inscription maximum'
            ])
            ->add('descriptioninfos',TextType::class, [
                'label' => 'Description'
            ])
            ->add('lieu',EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom_lieu',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nomLieu', 'ASC');
                }
            ])
            ->add('campus',EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom_campus',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nomCampus', 'ASC');
                }
            ])
            ->add('save', SubmitType::class,[
                'label' =>'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
            ->add('publish', SubmitType::class,[
                'label' =>'Publier',
                'attr' => [
                    'class' => 'btn btn-primary w-100'
                ]
            ])
            ->add('cancel', SubmitType::class,[
                'label' =>'Annuler',
                'attr' => [
                    'class' => 'btn btn-danger w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}

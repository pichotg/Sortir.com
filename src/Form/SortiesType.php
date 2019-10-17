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
            ->add('datedebut',DateTimeType::class,[
                'required' => false,
                'empty_data' => null
            ])
            ->add('duree',IntegerType::class)
            ->add('datecloture',DateType::class)
            ->add('nbinscriptionsmax',IntegerType::class)
            ->add('descriptioninfos',TextType::class)
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
            ->add('Send', SubmitType::class,[
                'label' =>'Enregistrer'
            ])
            ->add('Publish', SubmitType::class,[
                'label' =>'Publier'
            ])
            ->add('Cancel', SubmitType::class,[
                'label' =>'Annuler'
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

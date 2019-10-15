<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Sorties;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('lieu',EntityType::class, [
              'class' => Lieux::class,
              'choice_label' => 'nom_lieu',
              'query_builder' => function(EntityRepository $repository) {
                  return $repository->createQueryBuilder('c')->orderBy('c.nomLieu', 'ASC');
              },
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('start',DateType::class,  [
              'label'    => 'Date Entre',
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('close',DateType::class,  [
              'label'    => 'et',
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('ownorganisateur',CheckboxType::class,  [
              'label'    => 'Sorties dont je suis organisateur',
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('subscibed',CheckboxType::class,  [
              'label'    => 'Sorties auxquelle je suis inscrit',
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('unsubscribed',CheckboxType::class,  [
              'label'    => 'Sorties auxquelles je ne suis pas inscrit',
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('passed',CheckboxType::class,  [
              'label'    => 'Sorties passées',
              'required'      => false,
              'empty_data' => null,
              'mapped' => false
          ])
          ->add('submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
             'validation_groups' => false,
            ]);
    }
}

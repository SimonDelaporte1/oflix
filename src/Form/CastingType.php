<?php

namespace App\Form;

use App\Entity\Casting;
use App\Entity\Person;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CastingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', null,  [
                'label'=>'Role',
            ])
            ->add('creditOrder', null,  [
                'label'=>'Ordre d\'apparition',
            ])
            ->add('person', EntityType::class, [
                'class' => Person::class,
                'choice_label' => function ($person) {
                    return $person->getPersonFullName();
                },
                'multiple' => false,
                'expanded' => false
            ])
            ->add('movie', EntityType::class, [
                'class' => Movie::class,
                'choice_label' => 'title',
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Casting::class,
        ]);
    }
}

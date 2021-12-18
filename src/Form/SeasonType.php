<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'label'=>'Numéro de la saison',
            ])
            ->add('episodesNumber', null, [
                'label'=>'Nombre d\'épisode pour cette saison',
            ])
            ->add('movie', EntityType::class, [
                'label'=>'Film associé',
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
            'data_class' => Season::class,
        ]);
    }
}

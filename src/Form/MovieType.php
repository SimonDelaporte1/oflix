<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label'=>'Titre',
            ])
            ->add('type')
            ->add('releaseDate', null, [
                'label'=>'Date de sortie',
            ])
            ->add('summary', null, [
                'label'=>'Résumé',
            ])
            ->add('synopsis', null, [
                'label'=>'Synopsis',
            ])
            ->add('poster', null, [
                'label'=>'Image (URL)',
            ])
            ->add('rating', ChoiceType::class, [
                'label'=>'Avis',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices'  => [
                  'Excellent' => '5',
                  'Très bon' => '4',
                  'Bon' => '3',
                  'Peut mieux faire' => '2',
                  'A éviter' => '1', 
                ],
            ])
            ->add('duration', null, [
                'label'=>'Durée (minutes)',
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}

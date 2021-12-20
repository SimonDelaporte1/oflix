<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label'=>'Titre',
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Série' => 'Série',
                    'Film' => 'Film',
                ],
                'expanded' => true,
            ])
            ->add('releaseDate', DateType::class, [
                // Les années depuis le premier film à + 10 ans
                'years' => range(1895, date('Y') + 10),
                // Widget HTML5
                'html5' => true, // Déjà le cas par défaut
                'format' => 'yyyy-MM-dd', // Format nécessaire pour la datepicker
                'widget' => 'single_text',
            ])
            ->add('summary', null, [
                'label'=>'Résumé',
            ])
            ->add('synopsis', null, [
                'label'=>'Synopsis',
            ])
            ->add('poster', UrlType::class, [
                'help' => 'URL de l\'image',
            ])
            ->add('rating')
            ->add('duration', null, [
                'label'=>'Durée (minutes)',
                'help' => 'Durée en minutes',
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
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

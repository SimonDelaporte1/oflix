<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label'=> 'Pseudo'
            ])
            ->add('email', EmailType::class, [
                'label'=> 'Votre email'
            ])
            ->add('content', TextareaType::class, [
                'label'=> 'Critique'
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
            ->add('reactions', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices'  => [
                  'Rire' => 'smile',
                  'Pleurer' => 'cry',
                  'Réfléchir' => 'think',
                  'Dormir' => 'sleep',
                  'Rêver' => 'dream', 
                ],
                'label' => 'Ce film vous a fait...',
            ])
            ->add('watchedAt', DateType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Vous avez vu ce film le ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}

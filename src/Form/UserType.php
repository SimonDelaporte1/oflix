<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    // Libellé => Valeur
                    'Utilisateur' => 'ROLE_USER',
                    'Gestionnaire' => 'ROLE_MANAGER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                // Choix multiple => Tableau ;)
                'multiple' => true,
                // On veut des checkboxes !
                'expanded' => true,
            ])
            ->add('password', null, [
                // En cas d'erreur du type
                // Expected argument of type "string", "null" given at property path "password".
                // (notamment à l'edit en cas de passage d'une valeur existante à vide)
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Regex(
                        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                        "Le mot de passe doit contenir au minimum 8 caractères, une majuscule, un chiffre et un caractère spécial"
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
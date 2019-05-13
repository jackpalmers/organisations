<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserManageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]
            ])
            ->add('email', null, [
                'label' => 'Adresse email',
                'attr' => [
                    'placeholder' => 'Adresse email'
                ]
            ])
            ->add('Enregistrer', SubmitType::class);
//            ->add('oldUsername', TextType::class, [
//                'label' => 'Ancien nom d\'utilisateur',
//                'mapped' => false
//            ])
//            ->add('newUsername', TextType::class, [
//                'label' => 'Nouveau nom d\'utilisateur',
//                'mapped' => false
//            ])
//            ->add('password', PasswordType::class, [
//                'label' => 'Mot de passe',
//                'mapped' => false
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

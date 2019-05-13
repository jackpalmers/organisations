<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'required' => true,
                    'first_options'  => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Répétez le mot de passe'),
                    'constraints' => [
                        new Assert\NotBlank(['message' => "Le mot de passe est obligatoire."]),
//                        new Assert\Length([
//                            'min' => 8,
//                            'minMessage' => 'Le mot de passe doit comporter plus de {{ limit }} caractères.',
//                        ]),
                    ],
                    'invalid_message' => 'Le mot de passe doit être identique.',
                    'options' => ['attr' => [
                        'class' => 'password-field',
                        'placeholder' => "Mot de passe"
                    ]],
                ])
            ->add('email');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

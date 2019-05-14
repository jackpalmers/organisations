<?php

namespace App\Form;

use App\Entity\FicheBug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheBugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $formEvent){
//            $form = $formEvent->getForm();
//            $objet = $formEvent->getData();
//
//        });

            $builder
                ->add('projectName', TextType::class, [
                    'label' => 'Nom du projet',
                    'attr' => [
                        'placeholder' => 'Nom du projet'
                    ]
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description',
                    'attr' => [
                        'placeholder' => 'Description'
                    ]
                ])
                ->add('note', TextareaType::class, [
                    'label' => 'Note',
                    'attr' => [
                        'placeholder' => 'Note'
                    ],
                    'required' => false
                ]);
                if ($options['taskAlreadyCreated'])
                {
                    $builder
                        ->add('etat', ChoiceType::class, [
                            'choices' => [
                                'En cours' => 0,
                                'Terminée' => 1,
                                'Fermée' => 2
                            ]
                        ])
                        ->add('Enregister les modifications', SubmitType::class);
                }
                else
                {
                    $builder
                        ->add('Ajouter le bug', SubmitType::class);
                }
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheBug::class,
            'taskAlreadyCreated' => false
        ]);
    }
}

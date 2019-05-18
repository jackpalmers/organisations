<?php

namespace App\Form;

use App\Entity\Rdv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type',
                'attr' => [
                    'placeholder' => 'Type de rendez-vous'
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker w-auto',
                    'html5' => false
                ]
            ])
            ->add('heure', TimeType::class, [
                'label' => 'Heure'
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu',
                'attr' => [
                    'placeholder' => 'Lieu du rendez-vous'
                ]
            ]);
            if($options['edit'])
            {
                $builder
                ->add('Enregistrer les modifications', SubmitType::class);
            }
            else
            {
                $builder
                    ->add('Ajouter le rendez-vous', SubmitType::class);
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
            'edit' => false
        ]);
    }
}

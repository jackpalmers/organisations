<?php

namespace App\Form;

use App\Entity\TacheDev;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheDevType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projectName', TextType::class)
            ->add('description', TextareaType::class)
            ->add('note', TextareaType::class, [
                'required' => false
            ]);
//            ->add('etat',  ChoiceType::class, [
//                'choices' => [
//                    'En cours' => 0,
//                    'Terminée' => 1,
//                    'Fermée' => 2
//                ]
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TacheDev::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\TacheDev;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheDevType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $formEvent){
            $form = $formEvent->getForm();
            $objet = $formEvent->getData();

        });

        if ($options['theOption']){
            $builder
                ->add('tamerelapute', SubmitType::class);
        } else{
            $builder
                ->add('projectName', TextType::class)
                ->add('description', TextareaType::class)
                ->add('note', TextareaType::class, [
                    'required' => false
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TacheDev::class,
            'theOption' => false
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title', 
                TextType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Nom de la tâche'
                )
            )
            ->add(
                'description', 
                TextType::class,
                array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'Description de la tâche'
                )
            )
            ->add(
                'save', 
                SubmitType::class,
                array(
                    'attr' => array('class' => 'btn btn-outline-primary mt-3'),
                    'label' => 'Créer la tâche'
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}

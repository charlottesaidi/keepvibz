<?php

namespace App\Form;

use App\Entity\Audio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Genre',
                'choices'  => [
                    'Hip-Hop' => 'hip_hop',
                    'Trap' => 'trap',
                    'R\'n\'B' => 'R\'n\'B',
                    'Pop' => 'Pop',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('file', FileType::class, [
                'label' => 'Fichier',
                'data_class' => null
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Audio::class,
        ]);
    }
}

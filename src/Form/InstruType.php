<?php

namespace App\Form;

use App\Entity\Instru;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;

class InstruType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices'  => [
                    'Hip-Hop' => 'Hip Hop',
                    'Trap' => 'trap',
                    'R\'n\'B' => 'r\'n\'b',
                    'Pop' => 'pop',
                    'Autre' => 'autre'
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('bpm', IntegerType::class, [
                'label' => 'BPM',
            ])
            ->add('cle', TextType::class, [
                'label' => 'Key',
            ])
            ->add('file', FileType::class, [
                'label' => 'Fichier',
                'data_class' => null
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image associée',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Format d\'image non valide',
                    ])
                ],
                'data_class' => null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Instru::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Avatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('file', FileType::class, [
            'label' => 'Avatar utilisateur',
            'required' => false,
            'data_class' => null,
            'constraints' => [
                new Image([
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/gif',
                        'image/png',
                    ],
                    'message' => 'Format d\'image non valide',
                ])
            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avatar::class,
        ]);
    }
}

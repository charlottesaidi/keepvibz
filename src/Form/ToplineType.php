<?php

namespace App\Form;

use App\Entity\Topline;
use App\Entity\Instru;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ToplineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Fichier',
                'data_class' => null
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('instrus', EntityType::class, [
                'class' => Instru::class,
                'label' => 'Pour quelle morceau ?',
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topline::class,
        ]);
    }
}

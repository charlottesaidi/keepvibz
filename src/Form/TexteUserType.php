<?php

namespace App\Form;

use App\Entity\Texte;
use App\Entity\Instru;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TexteUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('refrain', TextareaType::class, [
                'label' => 'Refrain',
            ])
            ->add('couplet', TextareaType::class, [
                'label' => 'Couplet',
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
            'data_class' => Texte::class,
        ]);
    }
}

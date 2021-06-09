<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Region;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre',
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
        ])
        ->add('region', EntityType::class, [
            'class' => Region::class,
            'choice_label' => 'title',
            // 'multiple' => true,
            // 'expanded' => true,
        ])
        ->add('categories', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'title',
            'multiple' => true,
            'expanded' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

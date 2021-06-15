<?php

namespace App\Form;

use App\Entity\Contact;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',TypeTextType::class, [
                'label' => 'Pseudo'
            ]) 
            ->add('Email', EmailType::class, [
                'label' => 'Email'
            ]) // email type
            ->add('Subject',TypeTextType::class, [
                'label' => 'Objet'
            ]) // text type
            ->add('Message',TextareaType::class, [
                'label' => 'Message'
            ]) // textarea type
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

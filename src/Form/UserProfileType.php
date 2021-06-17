<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\AddressType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class)
            ->add('bio', TextareaType::class)
            ->add('town', TextType::class, [
                'attr' => [
                    'class' => 'ui-autocomplete-input',
                    'autocomplete' => 'off',
                    'name' => 'ville'
                ]
            ])
            ->add('phoneNumber', PhoneNumberType::class, [
                'default_region' => 'FR', 
                'format' => PhoneNumberFormat::NATIONAL,
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

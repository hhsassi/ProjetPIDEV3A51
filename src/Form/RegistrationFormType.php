<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}'],
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '[^0-9]+' ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '[^0-9]+' ],
            ])
            ->add("cin", TextType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '[0-9]+' ],
            ])
            ->add("adress", TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add("numTel", TextType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '[0-9]+' ],
            ])
            ->add("dob", BirthdayType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(1900, 2024),
                'label' => 'Date de naissance',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "En m'inscrivant a Artemis J'accepte ..."
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

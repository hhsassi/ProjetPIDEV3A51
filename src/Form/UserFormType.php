<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control', 'pattern' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}'],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your email.']),
            ],
        ])
        ->add('nom', TextType::class, [
            'attr' => ['class' => 'form-control', 'pattern' => '[^0-9]+' ],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your last name.']),
                new Length([
                    'max' => 10,
                    'maxMessage' => 'Nom cannot be longer than {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('prenom', TextType::class, [
            'attr' => ['class' => 'form-control', 'pattern' => '[^0-9]+' ],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your first name.']),
                new Length([
                    'max' => 10,
                    'maxMessage' => 'Prenom cannot be longer than {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('cin', TextType::class, [
            'attr' => ['class' => 'form-control', 'pattern' => '\d{8}'],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your CIN.']),
                new Length([
                    'min' => 8,
                    'max' => 8,
                    'exactMessage' => 'CIN must be exactly {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('adress', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your address.']),
            ],
        ])
        ->add('numTel', TextType::class, [
            'attr' => ['class' => 'form-control', 'pattern' => '\d+'],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your phone number.']),
                new Length([
                    'max' => 15,
                    'maxMessage' => 'NumTel cannot be longer than {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('dob', BirthdayType::class, [
            'widget' => 'choice',
            'format' => 'dd-MM-yyyy',
            'years' => range(1900, 2024),
            'label' => 'Date de naissance',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new NotBlank(['message' => 'Please enter your date of birth.']),
            ],
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue(['message' => 'You should agree to our terms.']),
            ],
            'label' => "En m'inscrivant a Artemis J'accepte ..."
        ])
        ->add('plainPassword', PasswordType::class, [
            'mapped' => false,
            'attr' => [
                'autocomplete' => 'new-password',
                'class' => 'form-control',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Please enter a password.']),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters.',
                    'max' => 4096,
                ]),
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

<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCertif', TextType::class, [
                'label' => 'Certification Name',
                
            ])
            ->add('descriptionCertif', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 5], 
            ])
            ->add('dureeCertif', ChoiceType::class, [
                'choices' => [
                    '1 month' => 1,
                    '2 months' => 2,
                    '4 months' => 4,
                    '1 year' => 12,
                ],
                'label' => 'Duration',
            ])
            ->add('niveauCertif', ChoiceType::class, [
                'choices' => [
                    'Level 1' => 1,
                    'Level 2' => 2,
                    'Level 3' => 3,
                ],
                'label' => 'Level',
            ])
            ->add('badgeCertif', FileType::class, [
                'label' => 'Badge (image file)',
                'mapped' => false, 
                'required' => false,
            ])
            /*->add('badgeCertif', FileType::class, [
                'label' => 'Badge Image (PNG or JPG)',
                'mapped' => false, // This field is not mapped to the entity property directly.
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG or JPG image.',
                    ])
                ],
            ])*/ 
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Base configuration options here
        ]);
    }
}

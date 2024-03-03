<?php

namespace App\Form;

use App\Entity\Certification; // Ensure this is included if you're going to select certifications
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // For linking to Certification entity
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TitreCours', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Title',
            ])
            ->add('descriptionCours', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'label' => 'Description',
            ])
            ->add('niveau', ChoiceType::class, [
                'choices' => [
                    'Beginner' => 'Beginner',
                    'Intermediate' => 'Intermediate',
                    'Advanced' => 'Advanced',
                ],
                'label' => 'Level',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('file', FileType::class, [
                'label' => 'Course Material (PDF, Image)',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('certification', EntityType::class, [
                'class' => Certification::class,
                'choice_label' => 'nomCertif',
                'label' => 'Certification',
                'attr' => ['class' => 'form-control'],
                // Add any additional options you need
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
      
        $resolver->setDefaults([
            'data_class' => \App\Entity\Cours::class,
        ]);
    }
}

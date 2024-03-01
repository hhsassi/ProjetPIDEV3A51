<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Certification;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\InscriptionCertif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionCertifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user') // Assurez-vous d'ajuster ces champs selon les propriétés de votre entité
            ->add('certification', EntityType::class, [
                'class' => Certification::class,
               
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                // Les autres options du champ...
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InscriptionCertif::class,
        ]);
    }
}

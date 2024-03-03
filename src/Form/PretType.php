<?php

namespace App\Form;

use App\Entity\Pret;
use App\Entity\Remboursement;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

class PretType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valeur', NumberType::class, [
                'label' => 'Montant du prêt'
            ])
            ->add('motif', TextType::class)
            ->add('salaire', IntegerType::class, [
                'required' => false
            ])
            ->add('garantie', CheckboxType::class, [
                'required' => false,
            ])
            ->add('valeur_garantie', NumberType::class, [
                'required' => false,
                'label' => 'Valeur de la garantie'
            ]);
            if ($options['is_admin'] === true) {
                $builder->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'fullName', // Ou toute autre propriété que vous souhaitez afficher comme libellé
                    'multiple' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->leftJoin('u.pret', 'p')
                            ->andWhere('p.id IS NULL')
                            ->orderBy('u.id', 'DESC');
                    },
                    'label' => 'Rattaché à quel utilisateur ?'
                ]);
            } else {
                $builder->add('user', EntityType::class, [
                    'class' => User::class,
                    'data' => $options['user'],
                    'disabled' => true,
                    'label' => 'Attaché à'
                ]);
            }

            $builder->add('remboursements', EntityType::class, [
                'class' => Remboursement::class,
                'choice_label' => 'valeur', // Ou toute autre propriété que vous souhaitez afficher comme libellé
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.id', 'ASC');
                },
                'label' => 'Remboursements associés'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', UserInterface::class);
//dd($resolver);
        $resolver->setDefaults([
            'data_class' => Pret::class,
            'is_admin' => false,
            'user' => null,
        ]);
        $resolver->setAllowedTypes('user', ['Symfony\Component\Security\Core\User\UserInterface', 'null']);
    }
}

<?php

namespace App\Form;

use App\Entity\Techno;
use App\Entity\Company;
use App\Entity\CompanyCritere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CompanyCritereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minimumSalary', IntegerType::class, [
                'label' => 'Salaire minimum',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('maximumSalary', IntegerType::class, [
                'label' => 'Salaire maximum ',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('experience', IntegerType::class, [
                'label' => 'Année minimum d\'expérience',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control   ',
                ]
            ])
            ->add('technos', EntityType::class, [
                'class' => Techno::class,
                'label' => 'Technologies requises où nécessaires',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => ' form-control mb-3 '
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyCritere::class,
        ]);
    }
}

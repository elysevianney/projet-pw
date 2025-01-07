<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
                   
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse complète',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Code Postal',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ],
                'constraints' => [
                    new Length([
                        'max' => 5,
                        'min' => 5,
                        'minMessage' => 'Il faut au moins {{ limit }} caractères',
                        'maxMessage' => 'Il faut au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                    ]),
                ],
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
            ->add('biography', TextareaType::class, [
                'label' => 'Description de l\'entreprise',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control   mb-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Techno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre du poste',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control  ',
                ]
                   
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse complète',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control c',
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
            ->add('experience', IntegerType::class, [
                'label' => 'Nombre d\'année d\'expérience',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('salary', IntegerType::class, [
                'label' => 'Estimer le salaire',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Petite biographie',
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
            'data_class' => Post::class,
        ]);
    }
}

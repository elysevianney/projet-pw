<?php

namespace App\Form;

use App\Entity\Dev;
use App\Entity\User;
use App\Entity\Technologie;
use App\Entity\DevTechnology;
use App\Entity\Techno;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DevType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
                   
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
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
            ->add('experience', IntegerType::class, [
                'label' => 'Nombre d\'année d\'expérience',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('minimumSalay', IntegerType::class, [
                'label' => 'Estimer votre salaire minimum',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Petite biographie',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control   ',
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control   ',
                ]
            ])
            ->add('publicProfile',  CheckboxType::class, [
                'required' => false,
                'label' => 'Garder votre profil public ?',
                'attr' => [
                    'class' => 'ml-3'
                ]
            ])
            ->add('technos', EntityType::class, [
                'class' => Techno::class,
                'label' => 'Technologies maîtrisées',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => ' form-control mb-3 '
                ]
            ])
            /*
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dev::class,
        ]);
    }
}

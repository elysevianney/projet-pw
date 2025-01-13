<?php

namespace App\Form;

use App\Entity\Dev;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Techno;
use App\Entity\Company;
use App\Entity\DevCritere;
use App\Entity\Technologie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DevSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('experience', IntegerType::class, [
                'required' => false,
                'label' => 'Nombre d\'année d\'expérience',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('minimumSalay', IntegerType::class, [
                'required' => false,
                'label' => 'salaire minimum',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('city', TextType::class, [
                'required' => false,
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'mb-1'
                ],
                'attr' => [
                    'class' => 'form-control ',
                ]
            ])
            ->add('technos', EntityType::class, [
                'required' => false,
                'class' => Techno::class,
                'label' => 'Technologies maîtrisées',
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
            'data_class' => Dev::class,
        ]);
    }
}

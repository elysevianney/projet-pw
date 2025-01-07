<?php
/*
namespace App\Form;

use App\Entity\Dev;
use App\Entity\DevTechnology;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevUpdateProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('adress')
            ->add('postalCode')
            ->add('city')
            ->add('experience')
            ->add('minimumSalay')
            ->add('biography')
            ->add('avatar')
            ->add('telephone')
            ->add('publicProfile')
            ->add('technology', EntityType::class, [
                'class' => DevTechnology::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
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
*/
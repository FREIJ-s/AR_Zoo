<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\User;
use App\Entity\InfoAnimal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InfoAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('food')
            ->add('weight', NumberType::class)
            ->add('datePassage', null, [
                'widget' => 'single_text',
            ])
            ->add('veterinary', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'lastname',
            ])
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoAnimal::class,
        ]);
    }
}

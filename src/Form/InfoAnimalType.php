<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Employee;
use App\Entity\InfoAnimal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('food')
            ->add('weight')
            ->add('datePassage', null, [
                'widget' => 'single_text',
            ])
            ->add('veterinary', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'id',
            ])
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'id',
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

<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\AnimalBreed;
use App\Entity\Habitat;
use App\Entity\InfoAnimal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('creationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('breed', EntityType::class, [
                'class' => AnimalBreed::class,
                'choice_label' => 'id',
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'id',
            ])
            ->add('infoAnimal', EntityType::class, [
                'class' => InfoAnimal::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}

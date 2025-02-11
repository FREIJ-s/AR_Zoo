<?php

namespace App\Form;

use App\Entity\Access;
use App\Entity\Employee;
use App\Entity\Habitat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accessType')
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'id',
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Access::class,
        ]);
    }
}

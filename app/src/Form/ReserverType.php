<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class ReserverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank(['message' => 'Le prénom est obligatoire.'])]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank(['message' => 'Le nom est obligatoire.'])]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'L\'email est obligatoire.']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide.'])
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank(['message' => 'Le numéro de téléphone est obligatoire.'])]
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de visite',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'La date est obligatoire.']),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de réservation doit être aujourd\'hui ou dans le futur.'
                    ])
                ]
            ])
            ->add('time', TimeType::class, [
                'label' => 'Heure de visite',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank(['message' => 'L\'heure est obligatoire.'])]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}

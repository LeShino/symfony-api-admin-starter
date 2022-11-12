<?php

namespace App\Form;

use App\Entity\Api;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ApiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom API',
                ],
                'label' => 'Nom API',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('url', UrlType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://api.server360.com/v1',
                ],
                'label' => 'URL',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Active' => 'Active',
                    'Suspendu' => 'Suspendu',
                    'En maintenance' => 'En maintenance',
                    'Depreciee' => 'Depreciee',
                    'Indisponibilité definitive' => 'Indisponibilité definitive',
                ],
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Api::class,
        ]);
    }
}

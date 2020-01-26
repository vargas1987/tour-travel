<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingDomesticFlight;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationSettingDomesticFlightForm
 * @package AltezzaTravelBundle\Form\Tour
 */
class CalculationSettingDomesticFlightForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', EntityType::class, [
                'label' => 'From',
                'class' => TerritorialLocation::class,
                'choice_label' => 'title',
                'by_reference' => true,
                'placeholder' => false,
                'required' => true,
                'mapped' => true,
            ])
            ->add('departureTime', TimeType::class, [
                'label' => 'Departure',
                'html5' => true,
                'widget' => 'single_text',
                'with_seconds' => false,
                'placeholder' => false,
                'attr' => [
                    'data-type' => 'date-departure-time',
                    'data-format' => 'h:m',
                    'data-placeholder' => 'HH:MM',
                    'autocomplete' => 'off',
                ],
                'mapped' => true,
                'required' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Time(),
                ],
            ])
            ->add('arrival', EntityType::class, [
                'label' => 'To',
                'class' => TerritorialLocation::class,
                'choice_label' => 'title',
                'by_reference' => true,
                'placeholder' => false,
                'required' => true,
                'mapped' => true,
            ])
            ->add('arrivalTime', TimeType::class, [
                'label' => 'Arrival',
                'html5' => true,
                'widget' => 'single_text',
                'with_seconds' => false,
                'placeholder' => false,
                'attr' => [
                    'data-type' => 'date-arrival-time',
                    'data-format' => 'h:m',
                    'data-placeholder' => 'HH:MM',
                    'autocomplete' => 'off',
                ],
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Time(),
                ],
            ])
            ->add('adultPrice', NumberType::class, [
                'label' => 'Adult price',
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('childPrice', NumberType::class, [
                'label' => 'Child price',
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('adultXlPrice', NumberType::class, [
                'label' => 'Adult XL price',
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('childXlPrice', NumberType::class, [
                'label' => 'Child XL price',
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('tax', NumberType::class, [
                'label' => 'Taxes and levels',
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'mapped' => true,
                'attr' => [
                    'class' =>'text',
                    'rows' => 4,
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CalculationSettingDomesticFlight::class,
            'constraints' => [
                new UniqueEntity([
                    'fields' => [
                        'departure',
                        'departureTime',
                        'arrival',
                        'arrivalTime',
                    ],
                    'message' => 'Domestic flight with this direction and times already exists',
                ]),
            ],
        ]);
        ;
    }
}
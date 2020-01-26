<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\CalculationFlight;
use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationFlightType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationFlightType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('airportDeparture', EntityType::class, [
                'label' => false,
                'class' => TerritorialAirstrip::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'required' => true,
                'placeholder' => false,
                'error_bubbling' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('airportArrival', EntityType::class, [
                'label' => false,
                'class' => TerritorialAirstrip::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'required' => true,
                'placeholder' => false,
                'error_bubbling' => true,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('totalPax', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'text',
                ],
                'error_bubbling' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Number of Pax" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Number of Pax" field',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'Number of pax should be greater than or equal to {{ compared_value }}.'
                    ]),
                ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', CalculationFlight::class)
        ;
    }
}
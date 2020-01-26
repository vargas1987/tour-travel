<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCurrencyRate;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingCarRentalType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingFeeCraterType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingFeeParkEastAfricanType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingFeeParkForeignerType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingOtherType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingTransferType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationSettingsForm
 * @package AltezzaTravelBundle\Form\Tour
 */
class CalculationSettingsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currencyRates = $builder->create('currencyRates', FormType::class, [
            'label' => false,
            'error_bubbling' => false,
            'inherit_data' => false,
        ]);

        foreach ($options['currencyRates'] as $name => $currencyRate) {
            $currencyRateType = $builder->create($name, FormType::class, [
                'label' => false,
                'error_bubbling' => false,
                'inherit_data' => false,
                'mapped' => true,
                'data_class' => CalculationSettingCurrencyRate::class,
                'data' => $currencyRate,
            ]);

            $currencyRateType
                ->add('valueFrom', NumberType::class, [
                    'label' => false,
                    'attr' => [
                        'class' =>'text',
                    ],
                    'mapped' => true,
                    'required' => true,
                ])
                ->add('valueTo', NumberType::class, [
                    'label' => false,
                    'attr' => [
                        'class' =>'text',
                    ],
                    'mapped' => true,
                    'required' => true,
                ])
            ;

            $currencyRates->add($currencyRateType);
        }

        $builder
            ->add($currencyRates)
            ->add('feeParkEastAfrican', CollectionType::class, [
                'entry_type' => CalculationSettingFeeParkEastAfricanType::class,
                'data' => $options['feeParkEastAfrican'],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->add('feeParkForeigner', CollectionType::class, [
                'entry_type' => CalculationSettingFeeParkForeignerType::class,
                'data' => $options['feeParkForeigner'],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->add('feeCrater', CollectionType::class, [
                'entry_type' => CalculationSettingFeeCraterType::class,
                'data' => $options['feeCrater'],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->add('carRental', CollectionType::class, [
                'entry_type' => CalculationSettingCarRentalType::class,
                'data' => $options['carRental'],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->add('transfers', CollectionType::class, [
                'entry_type' => CalculationSettingTransferType::class,
                'data' => $options['transfers'],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->add('others', CollectionType::class, [
                'entry_type' => CalculationSettingOtherType::class,
                'data' => $options['others'],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
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
        $resolver
            ->setRequired('feeParkEastAfrican')
            ->setRequired('feeParkForeigner')
            ->setRequired('feeCrater')
            ->setRequired('carRental')
            ->setRequired('transfers')
            ->setRequired('others')
            ->setAllowedTypes('feeParkEastAfrican', 'array')
            ->setAllowedTypes('feeParkForeigner', 'array')
            ->setAllowedTypes('feeCrater', 'array')
            ->setAllowedTypes('carRental', 'array')
            ->setAllowedTypes('transfers', 'array')
            ->setAllowedTypes('others', 'array')
            ->setDefaults([
                'currencyRates' => [],
                'feeParkEastAfrican' => [],
                'feeParkForeigner' => [],
                'feeCrater' => [],
                'carRental' => [],
                'transfers' => [],
                'others' => [],
            ])
        ;
    }
}

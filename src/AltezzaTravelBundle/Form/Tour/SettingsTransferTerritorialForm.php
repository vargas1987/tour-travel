<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCurrencyRate;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingCarRentalType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingFeeCraterType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingFeeParkEastAfricanType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingFeeParkForeignerType;
use AltezzaTravelBundle\Form\Tour\CalculationSetting\CalculationSettingTransferType;
use AltezzaTravelBundle\Form\Tour\Settings\TransferTerritorialType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SettingsTransferTerritorialForm
 * @package AltezzaTravelBundle\Form\Tour
 */
class SettingsTransferTerritorialForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transferTerritorial', CollectionType::class, [
                'entry_type' => TransferTerritorialType::class,
                'data' => $options['transferTerritorial'],
                'allow_add' => true,
                'allow_delete' => true,
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
            ->setRequired('transferTerritorial')
            ->setAllowedTypes('transferTerritorial', 'array')
            ->setDefaults([
                'transferTerritorial' => [],
            ])
        ;
    }
}
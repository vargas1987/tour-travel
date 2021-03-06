<?php

namespace AltezzaTravelBundle\Form\Tour\CalculationSetting;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkForeigner;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationSettingFeeParkForeignerType
 * @package AltezzaTravelBundle\Form\Tour\CalculationSetting
 */
class CalculationSettingFeeParkForeignerType extends AbstractCalculationSettingFeeType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adult', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('child', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'error_bubbling' => true,
            ])
        ;

        parent::buildForm($builder, $options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', CalculationSettingFeeParkForeigner::class)
        ;
    }
}

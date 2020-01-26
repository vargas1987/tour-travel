<?php

namespace AltezzaTravelBundle\Form\Tour\CalculationSetting;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeCrater;
use AltezzaTravelBundle\Repository\TerritorialParkRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationSettingFeeCraterType
 * @package AltezzaTravelBundle\Form\Tour\CalculationSetting
 */
class CalculationSettingFeeCraterType extends AbstractCalculationSettingFeeType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceTsh', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('priceUsd', NumberType::class, [
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
            ->setDefault('data_class', CalculationSettingFeeCrater::class)
        ;
    }

    /**
     * @return \Closure
     */
    protected function getParkQbFilter()
    {
        return function(TerritorialParkRepository $er) {
            return $er->getCraterFeeQB();
        };
    }
}
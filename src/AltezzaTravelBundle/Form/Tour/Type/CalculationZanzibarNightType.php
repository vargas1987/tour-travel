<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\CalculationNightZanzibar;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationZanzibarNightType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationZanzibarNightType extends AbstractCalculationNightType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nightFrom', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
                'error_bubbling' => true,
            ])
            ->add('nightTo', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
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
            ->setDefault('data_class', CalculationNightZanzibar::class)
        ;
    }
}

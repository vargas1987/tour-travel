<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\CalculationNightSafari;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationSafariNightType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationSafariNightType extends AbstractCalculationNightType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('night', NumberType::class, [
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
            ->setDefault('data_class', CalculationNightSafari::class)
        ;
    }
}

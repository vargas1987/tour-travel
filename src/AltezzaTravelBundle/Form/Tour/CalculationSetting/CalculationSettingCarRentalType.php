<?php

namespace AltezzaTravelBundle\Form\Tour\CalculationSetting;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCarRental;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationSettingCarRentalType
 * @package AltezzaTravelBundle\Form\Tour\CalculationSetting
 */
class CalculationSettingCarRentalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countDays', ChoiceType::class, [
                'label' => false,
                'choices' => array_flip(CalculationSettingCarRental::COUNT_DAYS),
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('price', NumberType::class, [
                'label' => false,
                'constraints' => [
                    new Assert\GreaterThanOrEqual(1)
                ],
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'error_bubbling' => true,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => CalculationSettingCarRental::class,
//                'constraints' => [
//                    new UniqueEntity([
//                        'fields' => [
//                            'countDays',
//                        ],
//                        'message' => 'Car rental with this option already exists',
//                    ]),
//                ],
            ])
        ;
    }
}
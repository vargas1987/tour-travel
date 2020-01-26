<?php

namespace AltezzaTravelBundle\Form\Tour\CalculationSetting;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCarRental;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingOther;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationSettingOtherType
 * @package AltezzaTravelBundle\Form\Tour\CalculationSetting
 */
class CalculationSettingOtherType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
                'mapped' => true,
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
            ->add('isPerSafariDay', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
            ->add('isPerPerson', CheckboxType::class, [
                'label' => false,
                'required' => false,
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
                'data_class' => CalculationSettingOther::class,
            ])
        ;
    }
}

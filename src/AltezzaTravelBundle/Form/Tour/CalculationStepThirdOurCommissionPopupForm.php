<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\Calculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationStepThirdForm
 * @package AltezzaTravelBundle\Form\Tour
 */
class CalculationStepThirdOurCommissionPopupForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ourCommission', NumberType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Calculation our commission" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Calculation our commission" field',
                    ]),
                ],
                'error_bubbling' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'admin-btn',
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
            ->setDefaults([
                'csrf_protection' => false,
                'data_class' => Calculation::class,
                'error_bubbling' => true,
            ])
        ;
    }
}
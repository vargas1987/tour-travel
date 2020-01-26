<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\CalculationPersonAdult;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationAdultPersonType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationAdultPersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'text',
                    'placeholder' => 'Pax',
                ],
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Number of Adults" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Number of Adults" field',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'Number of Adults should be greater than or equal to {{ compared_value }}.',
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
            ->setDefault('data_class', CalculationPersonAdult::class)
        ;
    }
}

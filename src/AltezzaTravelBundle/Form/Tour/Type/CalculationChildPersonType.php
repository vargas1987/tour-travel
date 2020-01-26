<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\CalculationPersonChild;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationChildPersonType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationChildPersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('age', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'text',
                ],
                'constraints' => [
                    new Assert\GreaterThanOrEqual(1),
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
            ->setDefault('data_class', CalculationPersonChild::class)
        ;
    }
}

<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\HotelPriceSupplement;
use AltezzaTravelBundle\Entity\TypeSupplement;
use AltezzaTravelBundle\Repository\TypeSupplementRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HotelPriceSupplementType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelPriceSupplementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => TypeSupplement::class,
                'query_builder' => function(TypeSupplementRepository $er) {
                    return $er->getAllSortedQB();
                },
                'choice_label' => 'title',
                'label' => false,
                'required' => true,
                'placeholder' => false,
            ])
            ->add('price', NumberType::class, [
                'mapped' => true,
                'by_reference' => true,
                'attr' => [
                    'class' =>'text',
                ],
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Additional fee price should not be null.',
                    ]),
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'Additional fee price should be greater than 0.',
                    ]),
                ],
            ])
            ->add('dateFrom', DateType::class, [
                'label' => false,
                'required' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'attr' => [
                    'data-type' => 'date-from',
                    'data-format' => 'd M yy',
                    //'data-mask' => '99/99/9999',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
            ->add('dateTo', DateType::class, [
                'label' => false,
                'required' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'attr' => [
                    'data-type' => 'date-to',
                    'data-format' => 'd M yy',
                    //'data-mask' => '99/99/9999',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
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
                'data_class' => HotelPriceSupplement::class,
            ])
        ;
    }
}

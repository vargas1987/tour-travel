<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\HotelPriceAdditionalFee;
use AltezzaTravelBundle\Entity\TypeAdditionalFee;
use AltezzaTravelBundle\Repository\TypeAdditionalFeeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HotelPriceAdditionalFeeType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelPriceAdditionalFeeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => TypeAdditionalFee::class,
                'query_builder' => function(TypeAdditionalFeeRepository $er) {
                    return $er->getAllSortedQB();
                },
                'choice_label' => 'title',
                'choice_attr' => function (TypeAdditionalFee $entity = null) {
                    return [
                        'data-behavior-title' => $entity->getBehaviorTitle(),
                    ];
                },
                'label' => false,
                'required' => true,
                'placeholder' => false,
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'mapped' => true,
                'by_reference' => true,
                'error_bubbling' => true,
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
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => HotelPriceAdditionalFee::class,
            ])
        ;
    }
}

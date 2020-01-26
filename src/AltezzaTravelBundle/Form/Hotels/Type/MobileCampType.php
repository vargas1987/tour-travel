<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\HotelMobileCamp;
use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use AltezzaTravelBundle\Entity\TerritorialArea;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MobileCampType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class MobileCampType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('area', EntityType::class, [
                'label' => 'Area',
                'class' => TerritorialArea::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'required' => true,
                'placeholder' => false,
            ])
            ->add('airstrip', EntityType::class, [
                'label' => 'Closest airport / airstrip',
                'class' => TerritorialAirstrip::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'required' => true,
                'placeholder' => false,
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
            ])
            ->add('timeToAirstrip', NumberType::class, [
                'label' => 'Transfer Time (min)',
                'required' => true,
                'attr' => [
                    'class' =>'text',
                ],
                'constraints' => [
                    new Assert\Range([
                        'min' => 5,
                        'max' => 150,
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
                'data_class' => HotelMobileCamp::class,
                'parent_form' => null,
                'prototype_data' => new HotelMobileCamp(),
            ])
        ;
    }
}

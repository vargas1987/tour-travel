<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\AbstractCalculationDay;
use AltezzaTravelBundle\Entity\AbstractCalculationNight;
use AltezzaTravelBundle\Entity\Calculation;
use AltezzaTravelBundle\Form\Tour\Type\CalculationNightCollectionType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationSafariDayType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationSafariNightType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationZanzibarNightType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculationStepTwoForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Calculation $data */
        $data = $builder->getData();

        $builder
            ->add('safariNights', CollectionType::class, [
                'label' => false,
                'required' => false,
                'entry_type' => CalculationSafariNightType::class,
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => true,
            ])
            ->add('safariDays', CollectionType::class, [
                'label' => false,
                'required' => false,
                'entry_type' => CalculationSafariDayType::class,
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => true,
            ])
            ->add('zanzibarNights', CollectionType::class, [
                'label' => false,
                'required' => false,
                'entry_type' => CalculationZanzibarNightType::class,
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Calculate final price',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
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
            ->setDefault('csrf_protection', false)
            ->setDefault('data_class', Calculation::class)
        ;
    }
}

<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\HotelMakeStoryProgram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelMakeStoryProgramDetailsType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', HotelMakeStoryProgram::class)
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itinerary', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'Arrival to Tanzania' => 'arrival-tanzania',
                    'Taragine National Park' => 'taragine-national-park',
                ],
                'placeholder' => false,
            ])
            ->add('overnight', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'Mount Meru Hotel' => 'mount-meru-hotel',
                ],
                'placeholder' => false,
            ]);
    }
}

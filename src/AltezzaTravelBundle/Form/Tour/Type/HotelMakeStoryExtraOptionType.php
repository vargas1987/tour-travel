<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\HotelMakeStoryExtraOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class HotelMakeStoryExtraOptionType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', HotelMakeStoryExtraOptions::class)
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => false,
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'placeholder' => false,
                'data' => new \DateTime(),
                'attr' => [
                    'data-type' => 'date-from',
                    'data-format' => 'd M yy',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
            ->add('time', TextType::class, [
                'label' => false,
                'required' => true,
                'data' => '13:00',
            ])
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'data' => 'Flight',
            ])
        ;
    }
}

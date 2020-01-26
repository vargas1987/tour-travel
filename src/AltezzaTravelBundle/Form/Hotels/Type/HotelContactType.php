<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\HotelContact;
use AltezzaTravelBundle\Entity\TypeDepartment;
use AltezzaTravelBundle\Repository\TypeDepartmentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelContactType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('department', EntityType::class, [
                'class' => TypeDepartment::class,
                'query_builder' => function(TypeDepartmentRepository $er) {
                    return $er->getAllSortedQB();
                },
                'choice_label' => 'title',
                'label' => false,
                'required' => false,
                'placeholder' => 'Select department',
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'data-mask' => '+999999999999',
                    'data-placeholder' => '+255999999999',
                    'placeholder' => '+255999999999',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('comment', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Name of person or comment',
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
            ->setDefault('data_class', HotelContact::class)
        ;
    }
}

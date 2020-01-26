<?php

namespace AltezzaTravelBundle\Form\Hotels\Admin;

use AltezzaTravelBundle\Entity\TypeAccommodation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AccommodationTypeEditForm
 * @package AltezzaTravelBundle\Form\Hotels\Admin
 */
class AccommodationTypeEditForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        $builder
            ->add('type', TextType::class, [])
            ->add('countAdult', NumberType::class, [
                'attr' => [
                    'class' => 'text',
                ],
            ])
            ->add('countTeenager', NumberType::class, [
                'attr' => [
                    'class' => 'text',
                ],
            ])
            ->add('countChild', NumberType::class, [
                'attr' => [
                    'class' => 'text',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => !$entity->getType() ? 'Add' : 'Update',
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
            ->setDefaults([
                'data_class' => TypeAccommodation::class,
            ]);
    }
}
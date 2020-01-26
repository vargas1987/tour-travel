<?php

namespace AltezzaTravelBundle\Form\Hotels\Admin;

use AltezzaTravelBundle\Entity\HotelChain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RoomTypeEditForm
 * @package AltezzaTravelBundle\Form\Hotels\Admin
 */
class HotelChainEditForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        $builder
            ->add('title', TextType::class, [])
            ->add('submit', SubmitType::class, [
                'label' => !$entity->getId() ? 'Add' : 'Update',
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
                'data_class' => HotelChain::class,
            ])
        ;
    }
}

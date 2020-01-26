<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelRoomCollectionType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelRoomCollectionType extends CollectionType
{
    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['room_type'] = $options['room_type'];
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'hotel_room_collection';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('room_type')
        ;

        parent::configureOptions($resolver);
    }
}

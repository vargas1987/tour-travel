<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HotelRoomTypeChoiceType extends AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'hotel_room_type_choice';
    }
}

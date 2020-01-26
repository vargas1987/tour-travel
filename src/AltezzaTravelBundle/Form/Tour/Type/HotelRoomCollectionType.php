<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * Class HotelRoomCollectionType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class HotelRoomCollectionType extends CollectionType
{
    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'hotel_room_collection';
    }
}

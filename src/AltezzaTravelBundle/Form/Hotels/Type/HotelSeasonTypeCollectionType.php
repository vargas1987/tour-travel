<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * Class HotelSeasonTypeCollectionType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelSeasonTypeCollectionType extends CollectionType
{
    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'hotel_season_type_collection';
    }
}

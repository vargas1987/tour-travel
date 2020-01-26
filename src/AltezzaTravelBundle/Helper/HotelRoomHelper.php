<?php

namespace AltezzaTravelBundle\Helper;

use AltezzaTravelBundle\Entity\HotelRoom;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HotelRoomHelper
 * @package AltezzaTravelBundle\Helper
 */
class HotelRoomHelper extends AbstractHelper
{
    /**
     * @param HotelRoom[] $rooms
     * @param bool $excludeSpecific
     * @param bool $addEmpty
     * @param bool $usePlaceholder
     * @return array
     */
    public function getRoomSlugs($rooms, $excludeSpecific = false, $addEmpty = false, $usePlaceholder = false)
    {
        $slugs = new ArrayCollection();

        foreach ($rooms as $room) {
            if ($room->getRoomType()->isSpecific() && $excludeSpecific) {
                continue;
            }

            $slug = [
                'id' => $room->getId(),
                'title' => $room->getTitle($usePlaceholder) ? $room->getTitle($usePlaceholder) : 'All',
                'slug' => $room->getSlug($usePlaceholder),
            ];

            if (!$room->getTitle() && !$addEmpty) {
                continue;
            }

            $slugs->add($slug);
//            if (!$slugs->contains($slug)) {
//                if (!$room->getTitle()) {
//                    $slugsArray = $slugs->toArray();
//                    array_unshift($slugsArray, $slug);
//                    $slugs = new ArrayCollection($slugsArray);
//
//                    continue;
//                }
//
//                $slugs->add($slug);
//            }
        }

        return $slugs->toArray();
    }
}

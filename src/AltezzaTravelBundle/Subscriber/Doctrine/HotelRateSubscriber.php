<?php

namespace AltezzaTravelBundle\Subscriber\Doctrine;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Helper\HotelRateHelper;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * Class HotelRateSubscriber
 * @package AltezzaTravelBundle\Subscriber\Doctrine
 */
class HotelRateSubscriber extends AbstractSubscriber
{
    /** @var HotelRateHelper $hotelRateHelper */
    private $hotelRateHelper;

    /**
     * HotelRateSubscriber constructor.
     * @param HotelRateHelper $hotelRateHelper
     */
    public function __construct(HotelRateHelper $hotelRateHelper)
    {
        $this->hotelRateHelper = $hotelRateHelper;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Hotel) {
            if ($this->isInit($args, 'extraData') || $this->isChange($args, 'extraData')) {
                $this->updateHotelRates($entity);
            }
        }
    }

    /**
     * @param Hotel $hotel
     */
    private function updateHotelRates(Hotel $hotel)
    {
        $this->hotelRateHelper->updateHotelRates($hotel);
    }
}

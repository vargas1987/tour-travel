<?php

namespace AltezzaTravelBundle\Subscriber\Doctrine;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelPrice;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\HotelSeason;
use AltezzaTravelBundle\Entity\HotelSeasonType;
use AltezzaTravelBundle\Entity\HotelYearsOptions;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

/**
 * Class HotelPriceSubscriber
 * @package AltezzaTravelBundle\Subscriber\Doctrine
 */
class HotelPriceSubscriber extends AbstractSubscriber
{
    /**
     * @var Hotel[]|ArrayCollection
     */
    private $hotels;

    /**
     * @var HotelPrice[]|ArrayCollection
     */
    private $hotelPrices;

    /**
     * @var array
     */
    private $cacheArrayHotelPrice = [];

    /**
     * HotelPriceSubscriber constructor.
     */
    public function __construct()
    {
        $this->hotels = new ArrayCollection();
        $this->hotelPrices = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->addHotel($entity, true);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->addHotel($entity);
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            $this->addHotel($entity, true);
        }

        foreach ($this->hotels as $hotel) {
            $this->refreshHotelPrices($args, $hotel);
            $this->updateDateLastPrice($args, $hotel);
            $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(Hotel::class), $hotel);
        }

        foreach ($this->hotelPrices as $hotelPrice) {
            $args->getEntityManager()->persist($hotelPrice);
            $uow->computeChangeSet($em->getClassMetadata(HotelPrice::class), $hotelPrice);
        }

        $this->hotels->clear();
        $this->hotelPrices->clear();
    }

    /**
     * @param object $entity
     * @return void
     */
    private function addHotel($entity, $isInsertionOrDeletion = false)
    {
        if ($entity instanceof Hotel) {
            if ($isInsertionOrDeletion) {
                $this->hotels->removeElement($entity);

                return;
            }
            $hotel = $entity;
        } elseif ($entity instanceof HotelYearsOptions) {
            $hotel = $entity->getHotel();
        } elseif ($entity instanceof HotelRoom) {
            $hotel = $entity->getHotel();
        } elseif ($entity instanceof HotelSeason) {
            $hotel = $entity->getHotel();
        } elseif ($entity instanceof HotelSeasonType) {
            $hotel = $entity->getHotel();
        }

        if (isset($hotel) && !$this->hotels->contains($hotel)) {
            $this->hotels->add($hotel);
        }
    }

    /**
     * @param OnFlushEventArgs $args
     * @param Hotel            $hotel
     */
    private function refreshHotelPrices(OnFlushEventArgs $args, Hotel $hotel)
    {
        $em = $args->getEntityManager();

        $yearsList = $hotel->getYearsList(false, false);

        $hotelPrices = new ArrayCollection($em->getRepository(HotelPrice::class)
            ->createQueryBuilder('hp')
            ->where('hp.hotel = :hotel')
            ->andWhere('hp.year in (:years)')
            ->setParameter('hotel', $hotel)
            ->setParameter('years', $yearsList)
            ->getQuery()
            ->getResult()
        );

        foreach ($yearsList as $year) {
            foreach ($hotel->getSeasonTypes($year) as $seasonType) {
                foreach ($hotel->getRooms() as $room) {
                    foreach ($hotel->getMealPlans() as $mealPlanType) {
                        foreach ($room->getAccommodations() as $accommodationType) {
                            $existHotelPrice = $em->getRepository(HotelPrice::class)->findOneBy([
                                'hotel' => $hotel,
                                'mealPlanType' => $mealPlanType,
                                'room' => $room,
                                'accommodationType' => $accommodationType,
                                'seasonType' => $seasonType,
                                'year' => $year,
                            ]);

                            if ($existHotelPrice) {
                                $hotelPrices->removeElement($existHotelPrice);
                                continue;
                            }

                            $hotelPrice = (new HotelPrice())
                                ->setHotel($hotel)
                                ->setMealPlanType($mealPlanType)
                                ->setRoom($room)
                                ->setAccommodationType($accommodationType)
                                ->setSeasonType($seasonType)
                                ->setYear($year)
                            ;

                            $uniqueKey = $this->getHotelPriceUniqueKey($hotelPrice);
                            if (!array_key_exists($uniqueKey, $this->cacheArrayHotelPrice)) {
                                $this->cacheArrayHotelPrice[$uniqueKey] = true;
                                $hotel->addPrice($hotelPrice);

                                if (!$this->hotelPrices->contains($hotelPrice)) {
                                    $this->hotelPrices->add($hotelPrice);
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($hotelPrices as $hotelPrice) {
            $em->remove($hotelPrice);
        }
    }

    /**
     * @param OnFlushEventArgs $args
     * @param Hotel            $hotel
     * @return void
     */
    private function updateDateLastPrice(OnFlushEventArgs $args, Hotel $hotel)
    {
        $hotel->setPriceUpTo($hotel->getDateLastPrice());
    }

    /**
     * @param HotelPrice $hotelPrice
     * @return string
     */
    private function getHotelPriceUniqueKey(HotelPrice $hotelPrice)
    {
        return sprintf('%s-%s-%s-%s-%s-%s',
            $hotelPrice->getHotel()->getId(),
            $hotelPrice->getRoom()->getId(),
            $hotelPrice->getMealPlanType()->getType(),
            $hotelPrice->getAccommodationType()->getType(),
            $hotelPrice->getSeasonType()->getType(),
            $hotelPrice->getYear()
        );
    }
}

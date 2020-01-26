<?php

namespace AltezzaTravelBundle\Helper;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelPrice;
use AltezzaTravelBundle\Entity\HotelPriceAdditionalFee;
use AltezzaTravelBundle\Entity\HotelPriceSupplement;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\HotelSeason;
use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeAdditionalFee;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Entity\TypeSeason;
use AltezzaTravelBundle\Entity\TypeSupplement;
use AltezzaTravelBundle\Exception\HotelPriceByDateNotExistException;
use AltezzaTravelBundle\Exception\HotelSeasonByDateNotExistException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class HotelPickUpHelper
 * @package AltezzaTravelBundle\Helper
 */
class HotelPickUpHelper
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * HotelPickUpHelper constructor.
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface        $logger
     */
    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @param array $options
     * @return array
     */
    public function findHotelsWithoutMobileCampsByOptions(array $options)
    {
        /** @var TerritorialLocation $territorialLocation */
        $territorialLocation = $options['location'];
        /** @var TerritorialArea[]|ArrayCollection $territorialAreas */
        $territorialAreas = $options['area'];
        /** @var TypeMealPlan $typeMealPlan */
        $typeMealPlan = $options['typeMealPlan'];
        /** @var array $roomsOptions */
        $roomsOptions = $options['rooms'];

        $repository = $this->entityManager->getRepository(Hotel::class);
        $qb = $repository->getHotelsWithoutMobileCampsByLocationAndAreaQB($territorialLocation, $territorialAreas->toArray());
        $qb = $repository->filterHotelsByMealPlan($qb, [$typeMealPlan]);
        $qb = $repository->filterHotelsByRooms($qb, $roomsOptions);
        $qb = $repository->filterHotelsByEnabled($qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $options
     * @return array
     */
    public function findHotelsWithMobileCampsByOptions(array $options)
    {
        /** @var TerritorialLocation $territorialLocation */
        $territorialLocation = $options['location'];
        /** @var TerritorialArea[]|ArrayCollection $territorialAreas */
        $territorialAreas = $options['area'];
        /** @var TypeMealPlan $typeMealPlan */
        $typeMealPlan = $options['typeMealPlan'];
        /** @var array $roomsOptions */
        $roomsOptions = $options['rooms'];

        $repository = $this->entityManager->getRepository(Hotel::class);
        $qb = $repository->getHotelsWithMobileCampsByLocationAndAreaQB($territorialLocation, $territorialAreas->toArray());
        $qb = $repository->filterHotelsByMealPlan($qb, [$typeMealPlan]);
        $qb = $repository->filterHotelsByRooms($qb, $roomsOptions);
        $qb = $repository->filterHotelsByEnabled($qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $options
     * @return array
     */
    public function findHotelsByOptions(array $options)
    {
        $mobileCampHotels = $this->findHotelsWithMobileCampsByOptions($options);
        $standardHotels = $this->findHotelsWithoutMobileCampsByOptions($options);

        return array_merge($mobileCampHotels, $standardHotels);
    }

    /**
     * @param Hotel[]|array $hotels
     * @param array         $options
     * @return ArrayCollection
     */
    public function calculateHotelsAccommodations(array $hotels, array $options)
    {
        $result = new ArrayCollection();

        $typeMealPlan = $options['typeMealPlan'];
        $dateFrom = $options['dateFrom'];
        $dateTo = $options['dateTo'];

        $roomParams = $this->prepareRoomAccommodationRequest($options);

        $getRequiredRoomAccommodations = function (TypeRoom $roomType) use ($roomParams) {
            if (isset($roomParams[$roomType->getType()])) {
                return $roomParams[$roomType->getType()];
            }

            return false;
        };

        foreach ($hotels as $hotel) {
            $item = [
                'hotel' => $hotel,
                'rooms' => [],
            ];

            foreach ($hotel->getRooms() as $room) {
                /** @var TypeAccommodation[]|ArrayCollection $roomAccommodations */
                if (!$roomAccommodations = $getRequiredRoomAccommodations($room->getRoomType())) {
                    continue;
                }

                foreach ($room->getAccommodations() as $accommodationType) {
                    if (!$roomAccommodations->contains($accommodationType)) {
                        continue;
                    }

                    try {
                        $price = $this->calculateAccommodationPrice($hotel, $room, $typeMealPlan, $accommodationType, $dateFrom, $dateTo);
                        $price += $this->calculateAccommodationAdditionalFeePrice($hotel, $accommodationType, $dateFrom, $dateTo);
                        $price += $this->calculateAccommodationSupplementPrice($hotel, $accommodationType, $dateFrom, $dateTo);

                        $item['rooms'][] = [
                            'title' => $room->getTitle(true),
                            'accommodation' => $accommodationType,
                            'price' => $price
                        ];
                    } catch (HotelSeasonByDateNotExistException $exception) {
                        $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                        continue;
                    } catch (HotelPriceByDateNotExistException $exception) {
                        $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                        continue;
                    }
                }
            }

            if (count($item['rooms'])) {
                $result->add($item);
            }
        }

        return $result;
    }

    /**
     * @param Hotel     $hotel
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param array     $request
     * @return ArrayCollection
     */
    public function findOutCost(
        Hotel $hotel,
        \DateTime $dateFrom,
        \DateTime $dateTo,
        array $request
    ) {
        $result = new ArrayCollection();

        $mealPlanTypes = $this->prepareMealPlanTypesRequest($request);
        $roomParams = $this->prepareRoomAccommodationRequest($request);

        $getRequiredRoomAccommodations = function (TypeRoom $roomType) use ($roomParams) {
            if (isset($roomParams[$roomType->getType()])) {
                return $roomParams[$roomType->getType()];
            }

            return false;
        };

        $item = [
            'hotel' => $hotel,
            'rooms' => [],
        ];

        foreach ($hotel->getRooms() as $room) {
            /** @var TypeAccommodation[]|ArrayCollection $roomAccommodations */
            if (!$roomAccommodations = $getRequiredRoomAccommodations($room->getRoomType())) {
                continue;
            }

            $accommodationPrices = [];

            foreach ($room->getAccommodations() as $accommodationType) {
                if (!$roomAccommodations->contains($accommodationType)) {
                    continue;
                }

                try {
                    $prices = [];

                    foreach ($mealPlanTypes as $typeMealPlan) {
                        $prices[$typeMealPlan->getType()] = $this->calculateAccommodationPrice($hotel, $room, $typeMealPlan, $accommodationType, $dateFrom, $dateTo);
                        $prices[$typeMealPlan->getType()] += $this->calculateAccommodationAdditionalFeePrice($hotel, $accommodationType, $dateFrom, $dateTo);
                        $prices[$typeMealPlan->getType()] += $this->calculateAccommodationSupplementPrice($hotel, $accommodationType, $dateFrom, $dateTo);
                    }
                } catch (HotelSeasonByDateNotExistException $exception) {
                    $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                    continue;
                } catch (HotelPriceByDateNotExistException $exception) {
                    $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                    continue;
                }

                if (count($prices)) {
                    $accommodationPrices[$accommodationType->getType()] = [
                        'accommodation' => $accommodationType,
                        'prices' => $prices,
                    ];
                }
            }

            if (count($accommodationPrices)) {
                $item['rooms'][$room->getId()] = [
                    'room' => $room,
                    'accommodations' => $accommodationPrices,
                ];
            }
        }

        if (count($item['rooms'])) {
            $result->add($item);
        }

        return $result;
    }

    /**
     * @param array $request
     * @return TypeMealPlan[]|ArrayCollection
     */
    protected function prepareMealPlanTypesRequest(array $request)
    {
        $typeMealPlans = $request['typeMealPlan'];

        if ($typeMealPlans instanceof TypeMealPlan) {
            $typeMealPlans = new ArrayCollection([$typeMealPlans]);
        }

        return $typeMealPlans;
    }

    /**
     * @param array $request
     * @return array|mixed
     */
    protected function prepareRoomAccommodationRequest(array $request)
    {
        $result = array_reduce(
            $request['rooms'],
            function ($result, $option) {
                /** @var TypeRoom $roomType */
                $roomType = $option['roomType'];

                /** @var  $result ArrayCollection[] */
                if (!isset($result[$roomType->getType()])) {
                    $result[$roomType->getType()] = new ArrayCollection();
                }

                foreach ($option['accommodations'] as $accommodation) {
                    if (!$result[$roomType->getType()]->contains($accommodation)) {
                        $result[$roomType->getType()]->add($accommodation);
                    }
                }

                return $result;
            },
            []
        );

        return $result;
    }

    /**
     * @param Hotel             $hotel
     * @param HotelRoom         $room
     * @param TypeMealPlan      $mealPlanType
     * @param TypeAccommodation $accommodationType
     * @param \DateTime         $dateFrom
     * @param \DateTime         $dateTo
     * @return float|int
     * @throws HotelPriceByDateNotExistException
     * @throws HotelSeasonByDateNotExistException
     */
    public function calculateFullAccommodationPrice(
        Hotel $hotel,
        HotelRoom $room,
        TypeMealPlan $mealPlanType,
        TypeAccommodation $accommodationType,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ) {
        $price = 0;
        $price += $this->calculateAccommodationSupplementPrice($hotel, $accommodationType, $dateFrom, $dateTo);
        $price += $this->calculateAccommodationAdditionalFeePrice($hotel, $accommodationType, $dateFrom, $dateTo);
        $price += $this->calculateAccommodationPrice($hotel, $room, $mealPlanType, $accommodationType, $dateFrom, $dateTo);

        return $price;
    }

    /**
     * @param Hotel             $hotel
     * @param TypeAccommodation $accommodationType
     * @param \DateTime         $dateFrom
     * @param \DateTime         $dateTo
     * @return int
     */
    public function calculateAccommodationSupplementPrice(
        Hotel $hotel,
        TypeAccommodation $accommodationType,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ) {
        $result = 0;

        $hotelPriceRepository = $this->entityManager->getRepository(HotelPriceSupplement::class);
        $pricesQb = $hotelPriceRepository->getListQb();
        $hotelPriceRepository->filterListByHotel($pricesQb, $hotel);
        $hotelPriceRepository->filterListByPeriod($pricesQb, $dateFrom, $dateTo);

        $prices = $pricesQb->getQuery()->getResult();

        /**
         * @param \DateTime $date
         * @return HotelPriceSupplement[]|ArrayCollection|null
         */
        $getPriceBySupplementTypeAndDate = function (\DateTime $date) use ($prices) {
            $prices = (new ArrayCollection($prices))->filter(function (HotelPriceSupplement $price) use ($date) {
                return $price->getDateFrom() <= $date && $price->getDateTo() >= $date;
            });

            return $prices;
        };

        $interval = new \DateInterval( 'P1D' );
        $period = new \DatePeriod($dateFrom, $interval, $dateTo);

        foreach ($period as $date) {
            $pricesByDate = $getPriceBySupplementTypeAndDate($date);
            if ($pricesByDate->isEmpty()) {
                continue;
            }

            foreach ($pricesByDate as $priceByDate) {
                $result += $priceByDate->getPrice() * $accommodationType->getTotalPax();
            }
        }

        return (int) $result;
    }

    /**
     * @param Hotel             $hotel
     * @param TypeAccommodation $accommodationType
     * @param \DateTime         $dateFrom
     * @param \DateTime         $dateTo
     * @return int
     */
    public function calculateAccommodationAdditionalFeePrice(
        Hotel $hotel,
        TypeAccommodation $accommodationType,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ) {
        $result = 0;

        $hotelPriceRepository = $this->entityManager->getRepository(HotelPriceAdditionalFee::class);
        $pricesQb = $hotelPriceRepository->getListQb();
        $hotelPriceRepository->filterListByHotel($pricesQb, $hotel);
        $hotelPriceRepository->filterListByYears($pricesQb, $dateFrom->format('Y'), $dateTo->format('Y'));

        $prices = $pricesQb->getQuery()->getResult();

        /**
         * @param int $year
         * @return HotelPriceAdditionalFee[]|ArrayCollection|null
         */
        $getPricesByYear = function (int $year) use ($prices) {
            $prices = (new ArrayCollection($prices))->filter(function (HotelPriceAdditionalFee $price) use ($year) {
                return $price->getYear() === $year;
            });

            return $prices;
        };

        $interval = new \DateInterval( 'P1D' );
        $period = new \DatePeriod($dateFrom, $interval, $dateTo);

        foreach ($period as $date) {
            $pricesByDate = $getPricesByYear($date->format('Y'));
            if ($pricesByDate->isEmpty()) {
                continue;
            }

            $price = 0;
            foreach ($pricesByDate as $priceByDate) {
                switch ($priceByDate->getType()->getBehavior()) {
                    case TypeAdditionalFee::TYPE_BEHAVIOR_PER_PERSON:
                        $price = $priceByDate->getPrice() * $accommodationType->getTotalPax();
                        break;
                    case TypeAdditionalFee::TYPE_BEHAVIOR_CONCESSION_FEE_INCL:
                        if ($hotel->isConcessionFeesIncl()) {
                            $price = $priceByDate->getPrice() * $accommodationType->getTotalPax();
                        }
                        break;
                    case TypeAdditionalFee::TYPE_BEHAVIOR_WMA_ADULT_INCL:
                        if ($hotel->isWmaIncl()) {
                            $price = $priceByDate->getPrice() * $accommodationType->getCountAdult();
                        }
                        break;
                    case TypeAdditionalFee::TYPE_BEHAVIOR_WMA_CHILD_INCL:
                        if ($hotel->isWmaIncl()) {
                            $price = $priceByDate->getPrice() * $accommodationType->getCountTeenager();
                        }
                        break;
                    case TypeAdditionalFee::TYPE_BEHAVIOR_ALONE:
                    default:
                        $price = $priceByDate->getPrice();
                        break;
                }

                $result += $price;
            }
        }

        return (int) $result;
    }

    /**
     * @param Hotel             $hotel
     * @param HotelRoom         $room
     * @param TypeMealPlan      $mealPlanType
     * @param TypeAccommodation $accommodationType
     * @param \DateTime         $dateFrom
     * @param \DateTime         $dateTo
     * @return float|int
     * @throws HotelPriceByDateNotExistException
     * @throws HotelSeasonByDateNotExistException
     */
    public function calculateAccommodationPrice(
        Hotel $hotel,
        HotelRoom $room,
        TypeMealPlan $mealPlanType,
        TypeAccommodation $accommodationType,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ) {
        $seasons = $hotel->getSeasons($dateFrom, $dateTo);

        /**
         * @param \DateTime $date
         * @return HotelSeason|null
         */
        $getSeasonByDate = function (\DateTime $date) use ($seasons) {
            $season = $seasons->filter(function (HotelSeason $season) use ($date) {
                return $season->getDateFrom() <= $date && $season->getDateTo() >= $date;
            })->first();

            return $season;
        };

        $seasonTypes = $seasons->map(function (HotelSeason $season) {
            return $season->getType();
        });

        $hotelPriceRepository = $this->entityManager->getRepository(HotelPrice::class);
        $pricesQb = $hotelPriceRepository->getListQb();
        $hotelPriceRepository->filterListByRoom($pricesQb, $room);
        $hotelPriceRepository->filterListByTypeMealPlan($pricesQb, $mealPlanType);
        $hotelPriceRepository->filterListByTypeAccommodation($pricesQb, $accommodationType);

        $hotelPriceRepository->filterListByTypeSeasons($pricesQb, $seasonTypes);
        $hotelPriceRepository->filterListByYears($pricesQb, $dateFrom->format('Y'), $dateTo->format('Y'));

        $prices = $pricesQb->getQuery()->getResult();

        /**
         * @param TypeSeason $seasonType
         * @param \DateTime  $date
         * @return HotelPrice|null
         */
        $getPriceBySeasonTypeAndDate = function (TypeSeason $seasonType, \DateTime $date) use ($prices) {
            $price = (new ArrayCollection($prices))->filter(function (HotelPrice $price) use ($seasonType, $date) {
                return $price->getSeasonType() === $seasonType && $price->getYear() === (int) $date->format('Y');
            })->first();

            return $price;
        };

        $interval = new \DateInterval( 'P1D' );
        $period = new \DatePeriod($dateFrom, $interval, $dateTo);

        $result = 0;

        foreach ($period as $date) {
            if (!$season = $getSeasonByDate($date)) {
                throw new HotelSeasonByDateNotExistException();
            }

            if (!$price = $getPriceBySeasonTypeAndDate($season->getType(), $date)) {
                throw new HotelPriceByDateNotExistException();
            }

            $result += $price->getPrice();
        }

        return $result;
    }
}

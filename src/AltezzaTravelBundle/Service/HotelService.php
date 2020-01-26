<?php

namespace AltezzaTravelBundle\Service;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelPriceAdditionalFee;
use AltezzaTravelBundle\Entity\HotelPriceSupplement;
use AltezzaTravelBundle\Entity\HotelSeason;
use AltezzaTravelBundle\Entity\HotelSeasonType;
use AltezzaTravelBundle\Exception\HotelCopyException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class HotelService
 * @package AltezzaTravelBundle\Service
 */
class HotelService
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * HotelService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Hotel $hotel
     * @param int   $year
     * @param Hotel $fromHotel
     * @param int   $fromYear
     * @throws HotelCopyException
     */
    public function copySeasonsByHotelAndYear(Hotel $hotel, int $year, Hotel $fromHotel, int $fromYear)
    {
        if ($fromHotel->getSeasonTypes($fromYear)->isEmpty()) {
            throw new HotelCopyException('Hotel does not have seasons');
        }

        if ($fromHotel->getSeasonTypes($fromYear)->isEmpty()) {
            throw new HotelCopyException('Reference hotel does not have season types');
        }

        $dateFrom = new \DateTime('first day of January ' . $fromYear);
        $dateTo = new \DateTime('last day of December ' . $fromYear);
        $copyDateFrom = new \DateTime('first day of January ' . $year);
        $copyDateTo = new \DateTime('last day of December ' . $year);

        foreach ($fromHotel->getSeasonTypes($fromYear) as $seasonType) {
            if ($hotel->haveSeasonType($seasonType)) {
                continue;
            }

            $copyHotelSeasonType = new HotelSeasonType();
            $copyHotelSeasonType
                ->setHotel($hotel)
                ->setSeasonType($seasonType)
            ;

            $hotel->addHotelSeasonType($copyHotelSeasonType);
        }

        foreach ($hotel->getSeasons($copyDateFrom, $copyDateTo) as $season) {
            $hotel->removeSeason($season);
            $this->entityManager->remove($season);
        }

        foreach ($fromHotel->getSeasons($dateFrom, $dateTo) as $season) {
            /** @var HotelSeason $cloneSeason */
            $cloneSeason = clone $season;
            $cloneDateFrom = (new \DateTime())->setDate(
                $year,
                $cloneSeason->getDateFrom()->format('m'),
                $cloneSeason->getDateFrom()->format('d')
            );
            $cloneDateTo = (new \DateTime())->setDate(
                $year,
                $cloneSeason->getDateTo()->format('m'),
                $cloneSeason->getDateTo()->format('d')
            );

            $cloneSeason
                ->setHotel($hotel)
                ->setDateFrom($cloneDateFrom)
                ->setDateTo($cloneDateTo);

            $hotel->addSeason($cloneSeason);
        }
    }

    /**
     * @param Hotel $hotel
     * @param int   $year
     * @param Hotel $fromHotel
     * @param int   $fromYear
     */
    public function copyPriceAdditionalFeesByHotelAndYear(Hotel $hotel, int $year, Hotel $fromHotel, int $fromYear)
    {
        $hotelPriceAdditionalFees = $hotel->getPriceAdditionalFees();
        $this->filterDataByYear($hotelPriceAdditionalFees, $year);
        foreach ($hotelPriceAdditionalFees as $hotelPriceAdditionalFee) {
            $hotel->removePriceAdditionalFee($hotelPriceAdditionalFee);
            $this->entityManager->remove($hotelPriceAdditionalFee);
        }

        $copyHotelPriceAdditionalFees = $fromHotel->getPriceAdditionalFees();
        $this->filterDataByYear($copyHotelPriceAdditionalFees, $fromYear);
        foreach ($copyHotelPriceAdditionalFees as $copyHotelPriceAdditionalFee) {
            /** @var HotelPriceAdditionalFee $cloneHotelPriceAdditionalFee */
            $cloneHotelPriceAdditionalFee = clone $copyHotelPriceAdditionalFee;
            $cloneHotelPriceAdditionalFee
                ->setHotel($hotel)
                ->setYear($year)
            ;

            $hotel->addPriceAdditionalFee($cloneHotelPriceAdditionalFee);
        }
    }

    /**
     * @param Hotel $hotel
     * @param int   $year
     * @param Hotel $fromHotel
     * @param int   $fromYear
     */
    public function copyPriceSupplementsByHotelAndYear(Hotel $hotel, int $year, Hotel $fromHotel, int $fromYear)
    {
        $hotelPriceSupplements = $hotel->getPriceSupplements();
        $this->filterDataByYear($hotelPriceSupplements, $year);
        foreach ($hotelPriceSupplements as $hotelPriceSupplement) {
            $hotel->removePriceSupplement($hotelPriceSupplement);
            $this->entityManager->remove($hotelPriceSupplement);
        }

        $copyHotelPriceSupplements = $fromHotel->getPriceSupplements();
        $this->filterDataByYear($copyHotelPriceSupplements, $fromYear);
        foreach ($copyHotelPriceSupplements as $copyHotelPriceSupplement) {
            /** @var HotelPriceSupplement $cloneHotelPriceSupplement */
            $cloneHotelPriceSupplement = clone $copyHotelPriceSupplement;
            $cloneDateFrom = (new \DateTime())->setDate(
                $year,
                $cloneHotelPriceSupplement->getDateFrom()->format('m'),
                $cloneHotelPriceSupplement->getDateFrom()->format('d')
            );
            $cloneDateTo = (new \DateTime())->setDate(
                $year,
                $cloneHotelPriceSupplement->getDateTo()->format('m'),
                $cloneHotelPriceSupplement->getDateTo()->format('d')
            );

            $cloneHotelPriceSupplement
                ->setHotel($hotel)
                ->setDateFrom($cloneDateFrom)
                ->setDateTo($cloneDateTo)
            ;

            $hotel->addPriceSupplement($cloneHotelPriceSupplement);
        }
    }

    /**
     * @param object|ArrayCollection $data
     * @param int $year
     */
    public function filterDataByYear(&$data, int $year)
    {
        foreach ($data as $item) {
            if ((int) $item->getYear() !== $year) {
                $data->removeElement($item);
            }
        }
    }
}

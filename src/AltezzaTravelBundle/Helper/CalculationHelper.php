<?php

namespace AltezzaTravelBundle\Helper;

use AltezzaTravelBundle\Entity\AbstractCalculationDay;
use AltezzaTravelBundle\Entity\AbstractCalculationNight;
use AltezzaTravelBundle\Entity\Calculation;
use AltezzaTravelBundle\Entity\CalculationDaySafari;
use AltezzaTravelBundle\Entity\CalculationNightSafari;
use AltezzaTravelBundle\Entity\CalculationNightZanzibar;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CalculationHelper
 * @package AltezzaTravelBundle\Helper
 */
class CalculationHelper extends AbstractHelper
{
    /**
     * @param Calculation $calculation
     * @return array
     */
    public function transformSafariDays(Calculation $calculation)
    {
        return array_reduce(
            $calculation->getDaysByType(AbstractCalculationDay::TYPE_SAFARI)->toArray(),
            function ($result, CalculationDaySafari $daySafari) {
                $result[] = [
                    'countDays' => $daySafari->getCountDays(),
                    'park' => $daySafari->getPark()->getId(),
                ];

                return $result;
            },
            []
        );
    }

    /**
     * @param Calculation $calculation
     * @return array
     */
    public function transformSafariNights(Calculation $calculation)
    {
        return array_reduce(
            $calculation->getNightsByType(AbstractCalculationNight::TYPE_SAFARI)->toArray(),
            function ($result, CalculationNightSafari $nightSafari) {
                $result[] = [
                    'number' => $nightSafari->getNight(),
                    'hotel' => [
                        'id' => $nightSafari->getHotel()->getId(),
                        'title' => $nightSafari->getHotel()->getTitle(),
                        'mealPlan' => [
                            'type' => $nightSafari->getMealPlanType()->getType(),
                            'title' => $nightSafari->getMealPlanType()->getTitle(),
                        ],
                        'room' => [
                            'id' => $nightSafari->getRoom()->getId(),
                            'slug' => $nightSafari->getRoom()->getTitle(true),
                            'count' => $nightSafari->getCount(),
                            'type' => $nightSafari->getRoom()->getRoomType()->getType(),
                            'shortName' => $nightSafari->getRoom()->getRoomType()->getShortName(),
                            'accommodation' => [
                                'type' => $nightSafari->getAccommodation()->getType(),
                                'adult' => $nightSafari->getAccommodation()->getCountAdult(),
                                'teenager' => $nightSafari->getAccommodation()->getCountTeenager(),
                                'child' => $nightSafari->getAccommodation()->getCountChild(),
                            ],
                        ],
                    ],
                ];

                return $result;
            },
            []
        );
    }

    /**
     * @param Calculation $calculation
     * @return array
     */
    public function transformZanzibarNights(Calculation $calculation)
    {
        return array_reduce(
            $calculation->getNightsByType(AbstractCalculationNight::TYPE_ZANZIBAR)->toArray(),
            function ($result, CalculationNightZanzibar $nightZanzibar){
                $result[] = [
                    'numberFrom' => $nightZanzibar->getNightFrom(),
                    'numberTo' => $nightZanzibar->getNightTo(),
                    'hotel' => [
                        'id' => $nightZanzibar->getHotel()->getId(),
                        'title' => $nightZanzibar->getHotel()->getTitle(),
                        'mealPlan' => [
                            'type' => $nightZanzibar->getMealPlanType()->getType(),
                            'title' => $nightZanzibar->getMealPlanType()->getTitle(),
                        ],
                        'room' => [
                            'id' => $nightZanzibar->getRoom()->getId(),
                            'slug' => $nightZanzibar->getRoom()->getTitle(true),
                            'count' => $nightZanzibar->getCount(),
                            'type' => $nightZanzibar->getRoom()->getRoomType()->getType(),
                            'shortName' => $nightZanzibar->getRoom()->getRoomType()->getShortName(),
                            'accommodation' => [
                                'type' => $nightZanzibar->getAccommodation()->getType(),
                                'adult' => $nightZanzibar->getAccommodation()->getCountAdult(),
                                'teenager' => $nightZanzibar->getAccommodation()->getCountTeenager(),
                                'child' => $nightZanzibar->getAccommodation()->getCountChild(),
                            ],
                        ],
                    ],
                ];

                return $result;
            },
            []
        );
    }

    /**
     * @param Calculation $calculation
     * @return array
     */
    public function getDaysGroupsByLocation(Calculation $calculation)
    {
        return array_reduce(
            $calculation->getDays()->toArray(),
            function ($result, AbstractCalculationDay $day) {
                if (!\array_key_exists($day->getPark()->getId(), $result)) {
                    $result[$day->getPark()->getId()] = [
                        'park' => $day->getPark(),
                        'days' => 0,
                    ];
                }

                $result[$day->getPark()->getId()]['days'] += $day->getCountDays();

                return $result;
            },
            []
        );
    }

    /**
     * @param Calculation $calculation
     * @return array
     */
    public function getNightsGroupsByHotel(Calculation $calculation)
    {
        return array_reduce(
            $calculation->getNights()->toArray(),
            function ($result, AbstractCalculationNight $night) {
                if (!\array_key_exists($night->getHotel()->getId(), $result)) {
                    $result[$night->getHotel()->getId()] = [
                        'hotel' => $night->getHotel(),
                        'nights' => [],
                    ];
                }

                $result[$night->getHotel()->getId()]['nights'][] = $night;

                return $result;
            },
            []
        );
    }
}

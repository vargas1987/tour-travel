<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CalculationSettingCarRental
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingCarRentalRepository")
 * @ORM\Table(name="calculation_setting_car_rental")
 */
class CalculationSettingCarRental
{
    const COUNT_DAYS_ONE = 'one';
    const COUNT_DAYS_TWO = 'two';
    const COUNT_DAYS_THREE_GREATER_THAN_OR_EQUAL = 'gte_tree';

    const COUNT_DAYS = [
        self::COUNT_DAYS_ONE => '1 day safari',
        self::COUNT_DAYS_TWO => '2 day safari',
        self::COUNT_DAYS_THREE_GREATER_THAN_OR_EQUAL => '3+ day safari',
    ];

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @var string
     * @ORM\Column(name="count_days", type="string")
     */
    private $countDays;

    /**
     * @var integer
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @param int $days
     * @return string|null
     */
    public static function getSlugByCount(int $days)
    {
        switch (true) {
            case $days === 1:
                return self::COUNT_DAYS_ONE;
                break;
            case $days === 2:
                return self::COUNT_DAYS_TWO;
                break;
            case $days >= 3:
                return self::COUNT_DAYS_THREE_GREATER_THAN_OR_EQUAL;
                break;
            default:
                return null;
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCountDays()
    {
        return $this->countDays;
    }

    /**
     * @param string $countDays
     * @return $this
     */
    public function setCountDays($countDays)
    {
        $this->countDays = $countDays;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}
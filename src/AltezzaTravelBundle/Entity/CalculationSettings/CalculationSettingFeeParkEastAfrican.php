<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CalculationSettingsFeeParkEastAfrican
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingFeeParkEastAfricanRepository")
 */
class CalculationSettingFeeParkEastAfrican extends AbstractCalculationSettingFee
{
    /**
     * @var integer
     * @ORM\Column(name="car", type="integer")
     */
    private $car;

    /**
     * @var integer
     * @ORM\Column(name="driver", type="integer")
     */
    private $driver;

    /**
     * @var integer
     * @ORM\Column(name="adult", type="integer")
     */
    private $adult;

    /**
     * @var integer
     * @ORM\Column(name="child", type="integer")
     */
    private $child;

    /**
     * @return int
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param int $car
     * @return $this
     */
    public function setCar($car)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * @return int
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param int $driver
     * @return $this
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return int
     */
    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * @param int $adult
     * @return $this
     */
    public function setAdult($adult)
    {
        $this->adult = $adult;

        return $this;
    }

    /**
     * @return int
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param int $child
     * @return $this
     */
    public function setChild($child)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_PARK_EAST_AFRICAN;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return self::CURRENCY_TSH;
    }
}

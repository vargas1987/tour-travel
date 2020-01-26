<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CalculationSettingsFeeParkForeigner
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingFeeParkForeignerRepository")
 */
class CalculationSettingFeeParkForeigner extends AbstractCalculationSettingFee
{
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
        return self::TYPE_PARK_FOREIGNER;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return self::CURRENCY_USD;
    }
}

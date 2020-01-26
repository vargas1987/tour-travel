<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CalculationFeeCrater
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingFeeCraterRepository")
 */
class CalculationSettingFeeCrater extends AbstractCalculationSettingFee
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */private $priceTsh;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $priceUsd;

    /**
     * @return int
     */
    public function getPriceTsh()
    {
        return $this->priceTsh;
    }

    /**
     * @param int $priceTsh
     * @return $this
     */
    public function setPriceTsh($priceTsh)
    {
        $this->priceTsh = $priceTsh;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceUsd()
    {
        return $this->priceUsd;
    }

    /**
     * @param int $priceUsd
     * @return $this
     */
    public function setPriceUsd($priceUsd)
    {
        $this->priceUsd = $priceUsd;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_CRATER;
    }
}

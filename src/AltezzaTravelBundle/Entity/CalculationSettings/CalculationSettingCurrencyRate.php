<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingCurrencyRateRepository")
 * @ORM\Table(name="calculation_setting_currency_rate")
 */
class CalculationSettingCurrencyRate
{
    use CreateUpdateEntity;

    const CURRENCY_USD = 'USD';
    const CURRENCY_TSH = 'TSH';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="currency_from", type="string")
     */
    private $currencyFrom;

    /**
     * @var float
     * @ORM\Column(name="value_from", type="decimal", scale=4, precision=10)
     */
    private $valueFrom;

    /**
     * @var string
     * @ORM\Column(name="currency_to", type="string")
     */
    private $currencyTo;

    /**
     * @var float
     * @ORM\Column(name="value_to", type="decimal", scale=4, precision=10)
     */
    private $valueTo;

    /**
     * @var float
     * @ORM\Column(name="rate", type="decimal", scale=4, precision=10)
     */
    private $rate;

    public function __construct()
    {
        $this->valueFrom = 0;
        $this->valueTo = 0;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return sha1(number_format($this->getValueFrom(), 4).number_format($this->getValueTo(), 4));
    }

    /**
     * @return string
     */
    public function getCurrencyFrom()
    {
        return $this->currencyFrom;
    }

    /**
     * @param string $currencyFrom
     * @return $this
     */
    public function setCurrencyFrom($currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;

        return $this;
    }

    /**
     * @return float
     */
    public function getValueFrom()
    {
        return $this->valueFrom;
    }

    /**
     * @param float $valueFrom
     * @return $this
     */
    public function setValueFrom($valueFrom)
    {
        $this->valueFrom = $valueFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyTo()
    {
        return $this->currencyTo;
    }

    /**
     * @param string $currencyTo
     * @return $this
     */
    public function setCurrencyTo($currencyTo)
    {
        $this->currencyTo = $currencyTo;

        return $this;
    }

    /**
     * @return float
     */
    public function getValueTo()
    {
        return $this->valueTo;
    }

    /**
     * @param float $valueTo
     * @return $this
     */
    public function setValueTo($valueTo)
    {
        $this->valueTo = $valueTo;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return $this
     */
    public function setRate(float $rate)
    {
        $this->rate = $rate;

        return $this;
    }
}
<?php

namespace AltezzaTravelBundle\Model;

use AltezzaTravelBundle\Entity\AbstractCalculationPerson;
use AltezzaTravelBundle\Entity\CalculationPersonAdult;

/**
 * Class CalculationResultPricePerPerson
 * @package AltezzaTravelBundle\Model
 */
class CalculationResultPricePerPerson
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var AbstractCalculationPerson $child
     */
    private $person;

    /**
     * @var float
     */
    private $price;

    public function __construct()
    {
        $this->price = 0;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return AbstractCalculationPerson
     */
    public function getPerson(): AbstractCalculationPerson
    {
        return $this->person;
    }

    /**
     * @param AbstractCalculationPerson $person
     * @return $this
     */
    public function setPerson(AbstractCalculationPerson $person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        if ($this->person instanceof CalculationPersonAdult) {
            return $this->price * $this->person->getCount();
        }

        return $this->price;
    }
}
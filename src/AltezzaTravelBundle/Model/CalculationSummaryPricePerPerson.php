<?php

namespace AltezzaTravelBundle\Model;

use AltezzaTravelBundle\Entity\AbstractCalculationPerson;

/**
 * Class CalculationSummaryPricePerPerson
 * @package AltezzaTravelBundle\Model
 */
class CalculationSummaryPricePerPerson
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var AbstractCalculationPerson
     */
    private $person;

    /**
     * @var float
     */
    private $price;

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
    public function getPrice()
    {
        return $this->price ?? 0;
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
}
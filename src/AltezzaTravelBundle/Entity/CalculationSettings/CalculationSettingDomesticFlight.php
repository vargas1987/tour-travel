<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calculation_setting_domestic_flight")
 */
class CalculationSettingDomesticFlight
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var TerritorialLocation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation")
     * @ORM\JoinColumn(name="departure_territorial_location_id", referencedColumnName="id", nullable=false)
     */
    private $departure;

    /**
     * @var TerritorialLocation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation")
     * @ORM\JoinColumn(name="arrival_territorial_location_id", referencedColumnName="id", nullable=false)
     */
    private $arrival;

    /**
     * @var string
     * @ORM\Column(name="departure_time", type="time", nullable=false)
     */
    private $departureTime;

    /**
     * @var string
     * @ORM\Column(name="arrival_time", type="time", nullable=false)
     */
    private $arrivalTime;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var int
     * @ORM\Column(name="adult_price", type="integer")
     */
    private $adultPrice;

    /**
     * @var int
     * @ORM\Column(name="child_price", type="integer")
     */
    private $childPrice;

    /**
     * @var int
     * @ORM\Column(name="tax", type="string")
     */
    private $tax;

    /**
     * @var int
     * @ORM\Column(name="adult_xl_price", type="integer")
     */
    private $adultXlPrice;

    /**
     * @var int
     * @ORM\Column(name="child_xl_price", type="integer")
     */
    private $childXlPrice;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TerritorialLocation
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param TerritorialLocation $departure
     * @return $this
     */
    public function setDeparture(TerritorialLocation $departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * @return TerritorialLocation
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param TerritorialLocation $arrival
     * @return $this
     */
    public function setArrival(TerritorialLocation $arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * @param mixed $departureTime
     * @return $this
     */
    public function setDepartureTime($departureTime)
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    /**
     * @param string $arrivalTime
     * @return $this
     */
    public function setArrivalTime($arrivalTime)
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getAdultPrice()
    {
        return $this->adultPrice;
    }

    /**
     * @param int $adultPrice
     * @return $this
     */
    public function setAdultPrice(int $adultPrice)
    {
        $this->adultPrice = $adultPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getChildPrice()
    {
        return $this->childPrice;
    }

    /**
     * @param int $childPrice
     * @return $this
     */
    public function setChildPrice(int $childPrice)
    {
        $this->childPrice = $childPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     * @return $this
     */
    public function setTax(int $tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return int
     */
    public function getAdultXlPrice()
    {
        return $this->adultXlPrice;
    }

    /**
     * @param int $adultXlPrice
     * @return $this
     */
    public function setAdultXlPrice(int $adultXlPrice)
    {
        $this->adultXlPrice = $adultXlPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getChildXlPrice()
    {
        return $this->childXlPrice;
    }

    /**
     * @param int $childXlPrice
     * @return $this
     */
    public function setChildXlPrice(int $childXlPrice)
    {
        $this->childXlPrice = $childXlPrice;

        return $this;
    }
}
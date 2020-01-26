<?php

namespace  AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calculation_flight")
 */
class CalculationFlight
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Calculation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Calculation", inversedBy="flights")
     * @ORM\JoinColumn(name="calculation_id", referencedColumnName="id", nullable=false)
     */
    private $calculation;

    /**
     * @var bool
     * @ORM\Column(name="one_way", type="boolean")
     */
    private $oneWay;

    /**
     * @var TerritorialAirstrip
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialAirstrip")
     * @ORM\JoinColumn(name="arrival_airstrip_id", referencedColumnName="id", nullable=false)
     */
    private $airportArrival;

    /**
     * @var TerritorialAirstrip
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialAirstrip")
     * @ORM\JoinColumn(name="departure_airstrip_id", referencedColumnName="id", nullable=false)
     */
    private $airportDeparture;

    /**
     * @var integer $totalPax
     * @ORM\Column(name="total_pax", type="integer")
     */
    private $totalPax;

    /**
     * CalculationFlight constructor.
     */
    public function __construct()
    {
        $this->oneWay = true;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Calculation
     */
    public function getCalculation()
    {
        return $this->calculation;
    }

    /**
     * @param Calculation $calculation
     * @return $this
     */
    public function setCalculation(Calculation $calculation)
    {
        $this->calculation = $calculation;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOneWay()
    {
        return $this->oneWay;
    }

    /**
     * @param bool $oneWay
     * @return $this
     */
    public function setOneWay(bool $oneWay)
    {
        $this->oneWay = $oneWay;

        return $this;
    }

    /**
     * @return TerritorialAirstrip
     */
    public function getAirportArrival()
    {
        return $this->airportArrival;
    }

    /**
     * @param TerritorialAirstrip $airportArrival
     * @return $this
     */
    public function setAirportArrival(TerritorialAirstrip $airportArrival)
    {
        $this->airportArrival = $airportArrival;

        return $this;
    }

    /**
     * @return TerritorialAirstrip
     */
    public function getAirportDeparture()
    {
        return $this->airportDeparture;
    }

    /**
     * @param TerritorialAirstrip $airportDeparture
     * @return $this
     */
    public function setAirportDeparture(TerritorialAirstrip $airportDeparture)
    {
        $this->airportDeparture = $airportDeparture;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPax()
    {
        return $this->totalPax;
    }

    /**
     * @param int $totalPax
     * @return $this
     */
    public function setTotalPax(int $totalPax)
    {
        $this->totalPax = $totalPax;

        return $this;
    }
}
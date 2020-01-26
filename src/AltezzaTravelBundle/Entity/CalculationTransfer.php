<?php

namespace  AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Settings\TransferTerritorial;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calculation_transfer")
 */
class CalculationTransfer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Calculation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Calculation", inversedBy="transfers")
     * @ORM\JoinColumn(name="calculation_id", referencedColumnName="id", nullable=false)
     */
    private $calculation;

    /**
     * @var bool
     * @ORM\Column(name="one_way", type="boolean")
     */
    private $oneWay;

    /**
     * @var TransferTerritorial
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Settings\TransferTerritorial")
     * @ORM\JoinColumn(name="departure_transfer_territorial_id", referencedColumnName="id", nullable=false)
     */
    private $departure;

    /**
     * @var TransferTerritorial
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Settings\TransferTerritorial")
     * @ORM\JoinColumn(name="arrival_transfer_territorial_id", referencedColumnName="id", nullable=false)
     */
    private $arrival;

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
     * @return TransferTerritorial
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param TransferTerritorial $arrival
     * @return $this
     */
    public function setArrival(TransferTerritorial $arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * @return TransferTerritorial
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param TransferTerritorial $departure
     * @return $this
     */
    public function setDeparture(TransferTerritorial $departure)
    {
        $this->departure = $departure;

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
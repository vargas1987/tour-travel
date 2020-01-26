<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hotel_mobile_camp")
 */
class HotelMobileCamp
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="mobileCamps")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var TerritorialLocation $location
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialArea")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id", nullable=true)
     */
    private $area;

    /**
     * @var TerritorialAirstrip $airstrip
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialAirstrip")
     * @ORM\JoinColumn(name="airstrip_id", referencedColumnName="id", nullable=true)
     */
    private $airstrip;

    /**
     * @var integer $timeToAirstrip
     * @ORM\Column(name="time_to_airstrip", type="integer", nullable=false)
     */
    private $timeToAirstrip;

    /**
     * @ORM\Column(name="date_from", type="date")
     */
    private $dateFrom;

    /**
     * @ORM\Column(name="date_to", type="date")
     */
    private $dateTo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param Hotel $hotel
     */
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * @return TerritorialLocation
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param TerritorialLocation $location
     */
    public function setLocation(TerritorialLocation $location)
    {
        $this->location = $location;
    }

    /**
     * @return TerritorialArea|null
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param TerritorialArea|null $area
     */
    public function setArea(TerritorialArea $area = null)
    {
        $this->area = $area;
    }

    /**
     * @return TerritorialAirstrip
     */
    public function getAirstrip()
    {
        return $this->airstrip;
    }

    /**
     * @param TerritorialAirstrip $airstrip
     */
    public function setAirstrip(TerritorialAirstrip $airstrip)
    {
        $this->airstrip = $airstrip;
    }

    /**
     * @return integer
     */
    public function getTimeToAirstrip()
    {
        return $this->timeToAirstrip;
    }

    /**
     * @param integer $timeToAirstrip
     */
    public function setTimeToAirstrip($timeToAirstrip)
    {
        $this->timeToAirstrip = $timeToAirstrip;
    }

    /**
     * @return mixed
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param mixed $dateFrom
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return mixed
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param mixed $dateTo
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }
}

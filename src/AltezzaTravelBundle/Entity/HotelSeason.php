<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelSeasonRepository")
 * @ORM\Table(name="hotel_season")
 */
class HotelSeason
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Hotel $hotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="seasons")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var \DateTime $dateFrom
     * @ORM\Column(name="date_from", type="date")
     */
    private $dateFrom;

    /**
     * @var \DateTime $dateTo
     * @ORM\Column(name="date_to", type="date")
     */
    private $dateTo;

    /**
     * @var TypeSeason $type
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeSeason")
     * @ORM\JoinColumn(name="season_type", referencedColumnName="type")
     */
    private $type;

    /**
     * @return integer
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
     * @return $this
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime $dateFrom
     * @return $this
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTime $dateTo
     * @return $this
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @return TypeSeason
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TypeSeason $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->getDateFrom()
            ? (int) $this->getDateFrom()->format('Y')
            : $this->getDateTo()
                ? (int) $this->getDateTo()->format('Y')
                : date('Y');
    }
}

<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hotel_season_type")
 */
class HotelSeasonType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="hotelSeasonTypes")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeSeason", inversedBy="hotelSeasonTypes", cascade={"persist"})
     * @ORM\JoinColumn(name="type_season", referencedColumnName="type")
     */
    private $seasonType;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param mixed $hotel
     * @return $this
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeasonType()
    {
        return $this->seasonType;
    }

    /**
     * @param mixed $seasonType
     * @return $this
     */
    public function setSeasonType($seasonType)
    {
        $this->seasonType = $seasonType;

        return $this;
    }
}
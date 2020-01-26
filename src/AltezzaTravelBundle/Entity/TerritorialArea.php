<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="territorial_area")
 */
class TerritorialArea
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title",type="string", nullable=false)
     */
    private $title;

    /**
     * @var Hotel[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\Hotel", mappedBy="area")
     */
    private $hotels;

    /**
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation", inversedBy="areas")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=false)
     */
    private $location;

    /**
     * @var TerritorialAirstrip[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\TerritorialAirstrip", inversedBy="areas")
     * @ORM\JoinTable(
     *     name="territorial_area_airstrip",
     *     joinColumns={@ORM\JoinColumn(name="territorial_area_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="territorial_airtstrip_id", referencedColumnName="id")}
     * )
     */
    private $airstrips;

    /**
     * TerritorialArea constructor.
     */
    public function __construct()
    {
        $this->airstrips = new ArrayCollection();
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Hotel[]|ArrayCollection
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * @param Hotel[]|ArrayCollection $hotels
     * @return $this
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;

        return $this;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return TerritorialLocation
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return $this
     */
    public function setLocation(TerritorialLocation $location)
    {
        $location->addArea($this);
        $this->location = $location;

        return $this;
    }

    /**
     * @return TerritorialAirstrip[]|ArrayCollection
     */
    public function getAirstrips()
    {
        return $this->airstrips;
    }

    /**
     * @param TerritorialAirstrip[]|ArrayCollection $airstrips
     * @return $this
     */
    public function setAirstrips($airstrips)
    {
        $this->airstrips = $airstrips;

        return $this;
    }

    /**
     * @param TerritorialAirstrip $airstrip
     * @return $this
     */
    public function addAirstrip(TerritorialAirstrip $airstrip)
    {
        if (!$this->airstrips->contains($airstrip)) {
            $this->airstrips->add($airstrip);
        }

        return $this;
    }

    /**
     * @param TerritorialAirstrip $airstrip
     * @return $this
     */
    public function removeAirstrip(TerritorialAirstrip $airstrip)
    {
        if ($this->airstrips->contains($airstrip)) {
            $this->airstrips->removeElement($airstrip);
        }

        return $this;
    }
}

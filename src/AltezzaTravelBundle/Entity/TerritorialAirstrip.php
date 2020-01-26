<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="territorial_airstrip")
 */
class TerritorialAirstrip
{
    use CreateUpdateEntity;

    const TRANSFER_TYPE_AIRPORT = 'airport';

    const TRANSFER_TYPE_AIRSTRIP = 'airstrip';

    const TRANSFER_TYPES = [
        self::TRANSFER_TYPE_AIRPORT,
        self::TRANSFER_TYPE_AIRSTRIP,
    ];

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $type
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var Hotel[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\Hotel", mappedBy="airstrip")
     */
    private $hotels;

    /**
     * @var TerritorialLocation[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation", mappedBy="airstrips", orphanRemoval=true)
     */
    private $locations;

    /**
     * @var TerritorialArea[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\TerritorialArea", mappedBy="airstrips", orphanRemoval=true)
     */
    private $areas;

    /**
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;
    }

    /**
     * @return TerritorialLocation[]|ArrayCollection
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param TerritorialLocation[] $locations
     * @return $this
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;

        return $this;
    }

    /**
     * @param TerritorialLocation $location
     * @return $this
     */
    public function addLocation(TerritorialLocation $location)
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->addAirstrip($this);
        }

        return $this;
    }

    /**
     * @param TerritorialLocation $location
     * @return $this
     */
    public function removeLocation(TerritorialLocation $location)
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
        }

        return $this;
    }

    /**
     * @return TerritorialArea[]
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * @param TerritorialArea[] $areas
     * @return $this
     */
    public function setAreas($areas)
    {
        $this->areas = $areas;

        return $this;
    }

    /**
     * @param TerritorialArea $area
     * @return $this
     */
    public function addArea(TerritorialArea $area)
    {
        if (!$this->areas->contains($area)) {
            $this->areas->add($area);
            $area->addAirstrip($this);
        }

        return $this;
    }

    /**
     * @param TerritorialArea $area
     * @return $this
     */
    public function removeArea(TerritorialArea $area)
    {
        if ($this->areas->contains($area)) {
            $this->areas->removeElement($area);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
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
}

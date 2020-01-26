<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="territorial_location")
 */
class TerritorialLocation
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var TerritorialPark[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\TerritorialPark", mappedBy="location")
     */
    private $parks;

    /**
     * @var TerritorialArea[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\TerritorialArea", mappedBy="location")
     */
    private $areas;

    /**
     * @var TerritorialAirstrip[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\TerritorialAirstrip", inversedBy="locations")
     * @ORM\JoinTable(
     *     name="territorial_location_airstrip",
     *     joinColumns={@ORM\JoinColumn(name="territorial_location_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="territorial_airtstrip_id", referencedColumnName="id")}
     * )
     */
    private $airstrips;

    /**
     * TerritorialLocation constructor.
     */
    public function __construct()
    {
        $this->parks = new ArrayCollection();
        $this->areas = new ArrayCollection();
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return TerritorialPark[]
     */
    public function getParks()
    {
        return $this->parks;
    }

    /**
     * @param TerritorialPark[] $parks
     * @return $this
     */
    public function setParks($parks)
    {
        $this->parks = $parks;

        return $this;
    }

    /**
     * @param TerritorialPark $park
     * @return $this
     */
    public function addPark(TerritorialPark $park)
    {
        if (!$this->parks->contains($park)) {
            $this->parks->add($park);
        }

        return $this;
    }

    /**
     * @param TerritorialPark $park
     * @return $this
     */
    public function removePark(TerritorialPark $park)
    {
        if ($this->parks->contains($park)) {
            $this->parks->removeElement($park);
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

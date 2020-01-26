<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\TypeRoomRepository")
 * @ORM\Table(name="type_room")
 */
class TypeRoom
{
    use CreateUpdateEntity;

    /**
     * @var string $type
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="type", type="string", length=32, nullable=false, unique=true)
     * @ORM\OrderBy({"sort": "ASC"})
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="short_name", type="string", nullable=false)
     */
    private $shortName;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="color", length=6, nullable=true)
     */
    private $color;

    /**
     * @var bool
     * @ORM\Column(name="specific", type="boolean", nullable=false)
     */
    private $specific;

    /**
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=false)
     */
    private $sort;

    /**
     * @var TypeAccommodation[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\TypeRoomAccommodation", mappedBy="roomType", cascade={"persist"})
     */
    private $accommodationTypes;

    /**
     * @var HotelRoom[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelRoom", mappedBy="roomType")
     */
    private $rooms;

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
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     * @return $this
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;

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
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSpecific()
    {
        return $this->specific;
    }

    /**
     * @param bool $specific
     * @return $this
     */
    public function setSpecific(bool $specific)
    {
        $this->specific = $specific;

        return $this;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     * @return $this
     */
    public function setSort(int $sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return TypeAccommodation[]|ArrayCollection
     */
    public function getAccommodationTypes()
    {
        return $this->accommodationTypes;
    }

    /**
     * @param TypeAccommodation[]|ArrayCollection $accommodationTypes
     */
    public function setAccommodationTypes($accommodationTypes)
    {
        $this->accommodationTypes = $accommodationTypes;
    }

    public function addAccommodationType(TypeAccommodation $accommodationType)
    {
        if (!$this->accommodationTypes->contains($accommodationType)) {
            $this->accommodationTypes->add($accommodationType);
        }

        return $this;
    }

    /**
     * @return HotelRoom[]|ArrayCollection
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param HotelRoom[]|ArrayCollection $rooms
     * @return $this
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }
}

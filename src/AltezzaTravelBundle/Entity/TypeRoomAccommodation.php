<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="type_room_accommodation")
 */
class TypeRoomAccommodation
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @var TypeRoom
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeRoom", inversedBy="accommodationTypes")
     * @ORM\JoinColumn(name="room_type", referencedColumnName="type", nullable=false, onDelete="CASCADE")
     */
    private $roomType;

    /**
     * @var TypeAccommodation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeAccommodation", inversedBy="roomTypes")
     * @ORM\JoinColumn(name="accommodation_type", referencedColumnName="type", nullable=false, onDelete="CASCADE")
     */
    private $accommodationType;

    /**
     * @var integer
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return TypeRoom
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * @param TypeRoom $roomType
     * @return $this
     */
    public function setRoomType($roomType)
    {
        $this->roomType = $roomType;

        return $this;
    }

    /**
     * @return TypeAccommodation
     */
    public function getAccommodationType()
    {
        return $this->accommodationType;
    }

    /**
     * @param TypeAccommodation $accommodationType
     * @return $this
     */
    public function setAccommodationType($accommodationType)
    {
        $this->accommodationType = $accommodationType;

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
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }
}

<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Behat\Transliterator\Transliterator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelRoomRepository")
 * @ORM\Table(name="hotel_room")
 */
class HotelRoom
{
    use CreateUpdateEntity;

    const EMPTY_SLUG = '__empty__';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Hotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="rooms", cascade={"persist"})
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var TypeRoom
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeRoom", inversedBy="rooms")
     * @ORM\JoinColumn(name="type", referencedColumnName="type", nullable=false)
     */
    private $roomType;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var TypeAccommodation[]|ArrayCollection $accommodations
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\TypeAccommodation", fetch="EAGER")
     * @ORM\JoinTable(
     *     name="hotel_room_accommodation",
     *     joinColumns={@ORM\JoinColumn(name="room_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="accommodation_type", referencedColumnName="type")}
     * )
     */
    protected $accommodations;

    /**
     * @var HotelPrice[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelPrice", mappedBy="room", cascade={"persist", "remove"})
     */
    protected $prices;

    public function __construct()
    {
        $this->accommodations = new ArrayCollection();
        $this->prices = new ArrayCollection();
    }

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
     * @param Hotel|null $hotel
     * @return $this
     */
    public function setHotel(Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
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
    public function setRoomType(TypeRoom $roomType)
    {
        $this->roomType = $roomType;

        return $this;
    }

    /**
     * @param bool $placeholder
     * @return string
     */
    public function getTitle($placeholder = false)
    {
        if (!$this->title && $placeholder && $this->getRoomType()) {
            return $this->getRoomType()->getName();
        }

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
     * @param bool $placeholder
     * @return string
     */
    public function getSlug($placeholder = false)
    {
        if (!$this->getTitle($placeholder)) {
            return self::EMPTY_SLUG;
        }

        return Transliterator::transliterate($this->getTitle($placeholder), '-');
    }

    /**
     * @return TypeAccommodation[]|ArrayCollection
     */
    public function getAccommodations()
    {
        return $this->accommodations;
    }

    /**
     * @param TypeAccommodation[]|ArrayCollection $accommodations
     * @return $this
     */
    public function setAccommodations($accommodations)
    {
        $this->accommodations = $accommodations;

        return $this;
    }

    /**
     * @param TypeAccommodation $accommodation
     * @return $this
     */
    public function addAccommodation(TypeAccommodation $accommodation)
    {
        if (!$this->accommodations->contains($accommodation)) {
            $this->accommodations->add($accommodation);
        }

        return $this;
    }

    /**
     * @param TypeAccommodation $accommodation
     * @return $this
     */
    public function removeAccommodation(TypeAccommodation $accommodation)
    {
        if ($this->accommodations->contains($accommodation)) {
            $this->accommodations->removeElement($accommodation);
        }

        return $this;
    }

    /**
     * @return HotelPrice[]|ArrayCollection
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param HotelPrice[]|ArrayCollection $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }
}

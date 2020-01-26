<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Behat\Transliterator\Transliterator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\TypeSeasonRepository")
 * @ORM\Table(name="type_season")
 */
class TypeSeason
{
    use CreateUpdateEntity;

    /**
     * @var string $type
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="type", type="string", length=32, nullable=false, unique=true)
     */
    private $type;

    /**
     * @var string $title
     * @ORM\Column(name="title", type="string", length=32, nullable=false)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=false, options={"default": 1})
     */
    private $sort;

    /**
     * @var HotelPrice[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelPrice", mappedBy="seasonType", cascade={"persist", "remove"})
     */
    private $prices;

    /**
     * @var HotelSeasonType[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelSeasonType", mappedBy="seasonType")
     */
    private $hotelSeasonTypes;

    /**
     * TypeSeason constructor.
     */
    public function __construct()
    {
        $this->sort = 0;
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
        $this->setType(Transliterator::transliterate($title, '_'));

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

    /**
     * @return HotelPrice[]|ArrayCollection
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param HotelPrice[]|ArrayCollection $prices
     * @return $this
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;

        return $this;
    }

    /**
     * @return HotelSeasonType[]|ArrayCollection
     */
    public function getHotelSeasonTypes()
    {
        return $this->hotelSeasonTypes;
    }

    /**
     * @param HotelSeasonType[]|ArrayCollection $hotelSeasonTypes
     * @return $this
     */
    public function setHotelSeasonTypes($hotelSeasonTypes)
    {
        $this->hotelSeasonTypes = $hotelSeasonTypes;

        return $this;
    }
}

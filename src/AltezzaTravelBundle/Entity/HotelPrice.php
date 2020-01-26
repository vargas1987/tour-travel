<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelPriceRepository")
 * @ORM\Table(name="hotel_price",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="hotel_price_unique", columns={
 *              "hotel_id", "meal_plan_type", "room_id", "accommodation_type", "season_type", "year"
 *          })
 *      }
 * )
 */
class HotelPrice
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
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="prices")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var HotelRoom $room
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\HotelRoom", inversedBy="prices")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=false)
     */
    private $room;

    /**
     * @var TypeMealPlan $mealPlanType
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeMealPlan", inversedBy="prices")
     * @ORM\JoinColumn(name="meal_plan_type", referencedColumnName="type", nullable=false)
     */
    private $mealPlanType;

    /**
     * @var TypeAccommodation $accommodationType
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeAccommodation")
     * @ORM\JoinColumn(name="accommodation_type", referencedColumnName="type", nullable=false)
     */
    private $accommodationType;

    /**
     * @var TypeSeason $seasonType
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeSeason", inversedBy="prices")
     * @ORM\JoinColumn(name="season_type", referencedColumnName="type", nullable=false)
     */
    private $seasonType;

    /**
     * @var integer $year
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var integer $price
     * @ORM\Column(name="price", type="integer", options={"default": 0})
     */
    private $price;

    /**
     * HotelPrice constructor.
     */
    public function __construct()
    {
        $this->price = 0;
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
     * @param Hotel $hotel
     * @return $this
     */
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return HotelRoom
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param HotelRoom $room
     * @return $this
     */
    public function setRoom(HotelRoom $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return TypeMealPlan
     */
    public function getMealPlanType()
    {
        return $this->mealPlanType;
    }

    /**
     * @param TypeMealPlan $mealPlan
     * @return $this
     */
    public function setMealPlanType(TypeMealPlan $mealPlanType)
    {
        $this->mealPlanType = $mealPlanType;

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
     * @param TypeAccommodation $roomAccommodation
     * @return $this
     */
    public function setAccommodationType(TypeAccommodation $accommodationType = null)
    {
        $this->accommodationType = $accommodationType;

        return $this;
    }

    /**
     * @return TypeSeason
     */
    public function getSeasonType()
    {
        return $this->seasonType;
    }

    /**
     * @param TypeSeason $seasonType
     * @return $this
     */
    public function setSeasonType(TypeSeason $seasonType)
    {
        $this->seasonType = $seasonType;

        return $this;
    }

    /**
     * @return integer
     */
    public function getYear()
    {
        return (int) $this->year;
    }

    /**
     * @param integer $year
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}

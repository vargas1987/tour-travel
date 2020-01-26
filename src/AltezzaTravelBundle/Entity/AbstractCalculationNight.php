<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=32)
 * @ORM\DiscriminatorMap({
 *     "safari": "CalculationNightSafari",
 *     "zanzibar": "CalculationNightZanzibar"
 * })
 * @ORM\Entity()
 * @ORM\Table(name="calculation_night")
 */
abstract class AbstractCalculationNight
{
    use CreateUpdateEntity;

    const TYPE_SAFARI = 'safari';

    const TYPE_ZANZIBAR = 'zanzibar';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Calculation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Calculation", inversedBy="nights")
     * @ORM\JoinColumn(name="calculation_id", referencedColumnName="id", nullable=false)
     */
    private $calculation;

    /**
     * @var Hotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var TypeMealPlan
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeMealPlan")
     * @ORM\JoinColumn(name="meal_plan_type", referencedColumnName="type", nullable=false)
     */
    private $mealPlanType;

    /**
     * @var HotelRoom
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\HotelRoom")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=false)
     */
    private $room;

    /**
     * @var integer
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * @var TypeAccommodation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeAccommodation")
     * @ORM\JoinColumn(name="accommodation_type", referencedColumnName="type", nullable=false)
     */
    protected $accommodation;

    /**
     * AbstractCalculationNight constructor.
     */
    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Calculation
     */
    public function getCalculation()
    {
        return $this->calculation;
    }

    /**
     * @param Calculation $calculation
     * @return $this
     */
    public function setCalculation($calculation)
    {
        $this->calculation = $calculation;

        return $this;
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
     * @return TypeMealPlan
     */
    public function getMealPlanType()
    {
        return $this->mealPlanType;
    }

    /**
     * @param TypeMealPlan $mealPlanType
     * @return $this
     */
    public function setMealPlanType(TypeMealPlan $mealPlanType)
    {
        $this->mealPlanType = $mealPlanType;

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
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount(int $count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return TypeAccommodation
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }

    /**
     * @param TypeAccommodation $accommodation
     * @return $this
     */
    public function setAccommodation($accommodation)
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType();
}
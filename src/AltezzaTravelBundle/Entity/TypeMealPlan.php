<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\TypeMealPlanRepository")
 * @ORM\Table(name="type_meal_plan")
 */
class TypeMealPlan
{
    use CreateUpdateEntity;

    const MEAL_PLAN_TYPE_BB = 'bb';

    const MEAL_PLAN_TYPE_HB = 'hb';

    const MEAL_PLAN_TYPE_FB = 'fb';

    const MEAL_PLAN_TYPE_AI = 'ai';

    const MEAL_PLAN_TYPE_GP = 'gp';

    const MEAL_PLAN_TYPES = [
        self::MEAL_PLAN_TYPE_BB,
        self::MEAL_PLAN_TYPE_HB,
        self::MEAL_PLAN_TYPE_FB,
        self::MEAL_PLAN_TYPE_AI,
        self::MEAL_PLAN_TYPE_GP,
    ];

    /**
     * @var string $type
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="type", type="string", length=32, nullable=false, unique=true)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var integer
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

    /**
     * @var Hotel[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\Hotel", mappedBy="mealPlans")
     */
    private $hotels;

    /**
     * @var HotelPrice[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelPrice", mappedBy="mealPlanType", cascade={"persist", "remove"})
     */
    private $prices;

    /**
     * TypeMealPlan constructor.
     */
    public function __construct()
    {
        $this->hotels = new ArrayCollection();
        $this->prices = new ArrayCollection();
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
     * @return Hotel[]|ArrayCollection
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * @return HotelPrice[]|ArrayCollection
     */
    public function getPrices()
    {
        return $this->prices;
    }
}

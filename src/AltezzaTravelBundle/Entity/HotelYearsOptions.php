<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="hotel_years_options")
 */
class HotelYearsOptions
{
    use CreateUpdateEntity;

    const OPTION_TYPE_BOOLEAN = 'boolean';

    const OPTION_TYPE_INTEGER = 'integer';

    const OPTION_TYPE_STRING = 'string';

    const OPTION_TYPE_JSON = 'json';

    const PRICE_OPTION_VALUE_AMOUNT = 'amount';
    const PRICE_OPTION_VALUE_PERCENT = 'percent';

    const PRICE_OPTION_PER_PERSON_RATE = 'per-person-rate';
    const PRICE_OPTION_SINGLE_SUPPLEMENT = 'single-supplement';
    const PRICE_OPTION_THIRD_ADULT = 'third-adult';
    const PRICE_OPTION_FIRST_TEENAGER_SHARING = 'first-teenager-sharing';
    const PRICE_OPTION_SECOND_TEENAGER_SHARING = 'second-teenager-sharing';
    const PRICE_OPTION_TEENAGER_ALONE = 'teenager-alone';
    const PRICE_OPTION_FIRST_CHILD_SHARING = 'first-child-sharing';
    const PRICE_OPTION_SECOND_CHILD_SHARING = 'second-child-sharing';

    const PRICE_OPTION_MEAL_PLAN_ADULT = 'meal-plan-adult';
    const PRICE_OPTION_MEAL_PLAN_TEENAGER = 'meal-plan-teenager';
    const PRICE_OPTION_MEAL_PLAN_CHILD = 'meal-plan-child';

    const NOT_CONSTRAINT_OPTIONS_GREATER_THAN_ZERO = [
        self::PRICE_OPTION_SINGLE_SUPPLEMENT,
        self::PRICE_OPTION_THIRD_ADULT,
        self::PRICE_OPTION_FIRST_TEENAGER_SHARING,
        self::PRICE_OPTION_SECOND_TEENAGER_SHARING,
        self::PRICE_OPTION_TEENAGER_ALONE,
        self::PRICE_OPTION_FIRST_CHILD_SHARING,
        self::PRICE_OPTION_SECOND_CHILD_SHARING,
        self::PRICE_OPTION_MEAL_PLAN_ADULT,
        self::PRICE_OPTION_MEAL_PLAN_TEENAGER,
        self::PRICE_OPTION_MEAL_PLAN_CHILD,
    ];

    const INCLUDE_SUPPLEMENT_OPTIONAL = [
        self::PRICE_OPTION_FIRST_TEENAGER_SHARING,
        self::PRICE_OPTION_SECOND_TEENAGER_SHARING,
        self::PRICE_OPTION_FIRST_CHILD_SHARING,
        self::PRICE_OPTION_SECOND_CHILD_SHARING,
    ];

    const RECALCULATE_RATES_ON_SUBMIT = 'recalculate_rates_on_submit';

    /**
     * @param bool $includeTeenagerRange
     * @return array
     */
    public static function getPriceAdditionalPersonOptions(bool $includeTeenagerRange)
    {
        switch ($includeTeenagerRange) {
            case true:
                return [
                    self::PRICE_OPTION_PER_PERSON_RATE => 'Per Person Rate',
                    self::PRICE_OPTION_SINGLE_SUPPLEMENT => 'Single Supplement',
                    self::PRICE_OPTION_THIRD_ADULT => '3rd Adult',
                    self::PRICE_OPTION_FIRST_TEENAGER_SHARING => '1st teenager (sharing)',
                    self::PRICE_OPTION_SECOND_TEENAGER_SHARING => '2nd teenager (sharing)',
                    self::PRICE_OPTION_TEENAGER_ALONE => 'Teenager (alone)',
                    self::PRICE_OPTION_FIRST_CHILD_SHARING => '1st child (sharing)',
                    self::PRICE_OPTION_SECOND_CHILD_SHARING => '2nd child (sharing)',
                ];
            default:
                return [
                    self::PRICE_OPTION_PER_PERSON_RATE => 'Per Person Rate',
                    self::PRICE_OPTION_SINGLE_SUPPLEMENT => 'Single Supplement',
                    self::PRICE_OPTION_THIRD_ADULT => '3rd Adult',
                    self::PRICE_OPTION_FIRST_CHILD_SHARING => '1st child (sharing)',
                    self::PRICE_OPTION_SECOND_CHILD_SHARING => '2nd child (sharing)',
                ];
        }
    }

    /**
     * @param bool $includeTeenagerRange
     * @return array
     */
    public static function getPriceMealPlanPersonOptions(bool $includeTeenagerRange)
    {
        switch ($includeTeenagerRange) {
            case true:
                return [
                    self::PRICE_OPTION_MEAL_PLAN_ADULT => 'adult',
                    self::PRICE_OPTION_MEAL_PLAN_TEENAGER => 'teenager',
                    self::PRICE_OPTION_MEAL_PLAN_CHILD => 'child',
                ];
            default:
                return [
                    self::PRICE_OPTION_MEAL_PLAN_ADULT => 'adult',
                    self::PRICE_OPTION_MEAL_PLAN_CHILD => 'child',
                ];
        }
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Hotel $hotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="yearsOptions", cascade={"persist"})
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var string $slug
     * @ORM\Column(name="slug", type="string")
     */
    private $slug;

    /**
     * @var string $slug
     * @ORM\Column(name="type", type="string", nullable=false, options={"default": "boolean"})
     */
    private $type;

    /**
     * @var integer $year
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var mixed $value
     * @ORM\Column(name="value", type="text")
     */
    private $value;

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
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
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
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function getValue()
    {
        switch ($this->getType()) {
            case self::OPTION_TYPE_BOOLEAN:
                return (boolean) $this->value;
            case self::OPTION_TYPE_INTEGER:
                return (int) $this->value;
            case self::OPTION_TYPE_STRING:
                return (string) $this->value;
            case self::OPTION_TYPE_JSON:
                return json_decode($this->value, true);
            default;
                return (string) $this->value;
        }
    }

    /**
     * @param bool   $value
     * @param string $type
     * @return $this
     */
    public function setValue($value, $type = self::OPTION_TYPE_STRING)
    {
        $this->setType($type);

        switch ($type) {
            case self::OPTION_TYPE_BOOLEAN:
            case self::OPTION_TYPE_INTEGER:
                $this->value = (int) $value;
                break;
            case self::OPTION_TYPE_STRING:
                $this->value = (string) $value;
                break;
            case self::OPTION_TYPE_JSON:
                $this->value = (string) json_decode($value, true);
                break;
            default;
                $this->value = (string) $value;
        }

        return $this;
    }
}

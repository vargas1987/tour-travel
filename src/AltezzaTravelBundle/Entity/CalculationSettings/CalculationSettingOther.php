<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CalculationSettingOther
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\Entity()
 * @ORM\Table(name="calculation_setting_other")
 */
class CalculationSettingOther
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var bool
     * @ORM\Column(name="is_per_safari_day", type="boolean")
     */
    private $isPerSafariDay;
    /**
     * @var bool
     * @ORM\Column(name="is_per_person", type="boolean")
     */
    private $isPerPerson;

    /**
     * @var integer
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * CalculationSettingOther constructor.
     */
    public function __construct()
    {
        $this->isPerSafariDay = false;
        $this->isPerPerson = false;
    }

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
     * @return bool
     */
    public function isPerSafariDay()
    {
        return $this->isPerSafariDay;
    }

    /**
     * @param bool $isPerSafariDay
     * @return $this
     */
    public function setIsPerSafariDay($isPerSafariDay)
    {
        $this->isPerSafariDay = $isPerSafariDay;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPerPerson()
    {
        return $this->isPerPerson;
    }

    /**
     * @param bool $isPerPerson
     * @return $this
     */
    public function setIsPerPerson($isPerPerson)
    {
        $this->isPerPerson = $isPerPerson;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}

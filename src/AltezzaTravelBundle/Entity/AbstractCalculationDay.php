<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=32)
 * @ORM\DiscriminatorMap({
 *     "safari": "CalculationDaySafari"
 * })
 * @ORM\Entity()
 * @ORM\Table(name="calculation_day")
 */
abstract class AbstractCalculationDay
{
    use CreateUpdateEntity;

    const TYPE_SAFARI = 'safari';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Calculation
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Calculation", inversedBy="days")
     * @ORM\JoinColumn(name="calculation_id", referencedColumnName="id", nullable=false)
     */
    private $calculation;

    /**
     * @var TerritorialPark
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialPark")
     * @ORM\JoinColumn(name="park_id", referencedColumnName="id", nullable=false)
     */
    private $park;

    /**
     * @var integer
     * @ORM\Column(name="count_days", type="integer", nullable=false)
     */
    private $countDays;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCalculation()
    {
        return $this->calculation;
    }

    /**
     * @param mixed $calculation
     * @return $this
     */
    public function setCalculation($calculation)
    {
        $this->calculation = $calculation;

        return $this;
    }

    /**
     * @return TerritorialPark
     */
    public function getPark()
    {
        return $this->park;
    }

    /**
     * @param TerritorialPark $park
     * @return $this
     */
    public function setPark(TerritorialPark $park)
    {
        $this->park = $park;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountDays()
    {
        return $this->countDays;
    }

    /**
     * @param int $countDays
     * @return $this
     */
    public function setCountDays(int $countDays)
    {
        $this->countDays = $countDays;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType();
}
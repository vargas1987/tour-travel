<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CalculationNightZanzibar extends AbstractCalculationNight
{
    /**
     * @var integer
     * @ORM\Column(name="night_from", type="integer", nullable=false)
     */
    private $nightFrom;

    /**
     * @var integer
     * @ORM\Column(name="night_to", type="integer", nullable=false)
     */
    private $nightTo;

    /**
     * @return int
     */
    public function getNightFrom()
    {
        return $this->nightFrom;
    }

    /**
     * @param int $nightFrom
     * @return $this
     */
    public function setNightFrom(int $nightFrom)
    {
        $this->nightFrom = $nightFrom;

        return $this;
    }

    /**
     * @return int
     */
    public function getNightTo()
    {
        return $this->nightTo;
    }

    /**
     * @param int $nightTo
     * @return $this
     */
    public function setNightTo(int $nightTo)
    {
        $this->nightTo = $nightTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_ZANZIBAR;
    }
}
<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CalculationNightSafari extends AbstractCalculationNight
{
    /**
     * @var integer
     * @ORM\Column(name="night", type="integer", nullable=false)
     */
    private $night;

    /**
     * @return int
     */
    public function getNight()
    {
        return $this->night;
    }

    /**
     * @param int $night
     * @return $this
     */
    public function setNight(int $night)
    {
        $this->night = $night;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_SAFARI;
    }
}
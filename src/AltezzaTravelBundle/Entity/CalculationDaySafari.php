<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CalculationDaySafari extends AbstractCalculationDay
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_SAFARI;
    }
}
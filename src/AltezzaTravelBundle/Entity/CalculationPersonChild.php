<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CalculationPersonChild extends AbstractCalculationPerson
{
    /**
     * @var integer
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return $this
     */
    public function setAge(int $age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_CHILD;
    }
}
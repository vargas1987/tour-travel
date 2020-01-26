<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=32)
 * @ORM\DiscriminatorMap({
 *     "adult": "CalculationPersonAdult",
 *     "child": "CalculationPersonChild"
 * })
 * @ORM\Entity()
 * @ORM\Table(name="calculation_person")
 */
abstract class AbstractCalculationPerson
{
    use CreateUpdateEntity;

    const TYPE_ADULT = 'adult';

    const TYPE_CHILD = 'child';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Calculation", inversedBy="persons")
     * @ORM\JoinColumn(name="calculation_id", referencedColumnName="id", nullable=false)
     */
    private $calculation;

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
     * @return string
     */
    abstract public function getType();
}
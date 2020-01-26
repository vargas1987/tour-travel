<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\TypeAdditionalFeeRepository")
 * @ORM\Table(name="type_additional_fee")
 */
class TypeAdditionalFee
{
    use CreateUpdateEntity;

    const TYPE_BEHAVIOR_PER_PERSON = 'per_person';

    const TYPE_BEHAVIOR_CONCESSION_FEE_INCL = 'concession_fee_incl';

    const TYPE_BEHAVIOR_WMA_ADULT_INCL = 'wma_adult_incl';

    const TYPE_BEHAVIOR_WMA_CHILD_INCL = 'wma_child_incl';

    const TYPE_BEHAVIOR_ALONE = 'alone';

    /**
     * @var string $type
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="type", type="string", length=32, nullable=false, unique=true)
     */
    private $type;

    /**
     * @var string $behavior
     * @ORM\Column(name="behavior", type="string", length=32, nullable=false)
     */
    private $behavior;

    /**
     * @var string $title
     * @ORM\Column(name="title", type="string", length=32, nullable=false)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=false, options={"default": 1})
     */
    private $sort;

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
     * @return string
     */
    public function getBehavior()
    {
        return $this->behavior;
    }

    /**
     * @return string
     */
    public function getBehaviorTitle()
    {
        switch ($this->behavior) {
            case self::TYPE_BEHAVIOR_PER_PERSON:
                return 'Per person';
            case self::TYPE_BEHAVIOR_CONCESSION_FEE_INCL:
                return 'Concession fees incl';
            case self::TYPE_BEHAVIOR_ALONE:
                return 'Alone';
            default:
                return 'Unknown';
        }
    }

    /**
     * @param string $behavior
     * @return $this
     */
    public function setBehavior(string $behavior)
    {
        $this->behavior = $behavior;

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
    public function setTitle(string $title)
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
     * @param string|null $description
     * @return $this
     */
    public function setDescription(string $description = null)
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
    public function setSort(int $sort)
    {
        $this->sort = $sort;

        return $this;
    }
}
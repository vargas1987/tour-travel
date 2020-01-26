<?php

namespace AltezzaTravelBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\TypeAccommodationRepository")
 * @ORM\Table(name="type_accommodation")
 */
class TypeAccommodation
{
    /**
     * @var string $type
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="type", type="string", length=32, nullable=false, unique=true)
     */
    private $type;

    /**
     * @var integer $countAdult
     * @ORM\Column(name="count_adult", type="integer")
     */
    private $countAdult;

    /**
     * @var integer $countTeenager
     * @ORM\Column(name="count_teenager", type="integer")
     */
    private $countTeenager;

    /**
     * @var integer $countChild
     * @ORM\Column(name="count_child", type="integer")
     */
    private $countChild;

    /**
     * @var TypeRoomAccommodation[]|ArrayCollection $roomTypes
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\TypeRoomAccommodation", mappedBy="accommodationType", cascade={"persist"})
     */
    private $roomTypes;

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
     * @throws \Exception
     */
    public function generateType()
    {
        $type = '';

        if ($this->getCountAdult()) {
            $type .= $this->getCountAdult().'A';
        }

        if ($this->getCountTeenager()) {
            $type .= $this->getCountTeenager().'T';
        }

        if ($this->getCountChild()) {
            $type .= $this->getCountChild().'C';
        }

        if (empty($type)) {
            throw new \Exception('Type accommodation can not by empty');
        }

        return $type;
    }

    /**
     * @return int
     */
    public function getCountAdult()
    {
        return $this->countAdult;
    }

    /**
     * @param int $countAdult
     * @return $this
     */
    public function setCountAdult($countAdult)
    {
        $this->countAdult = $countAdult;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountTeenager()
    {
        return $this->countTeenager;
    }

    /**
     * @param int $countTeenager
     * @return $this
     */
    public function setCountTeenager($countTeenager)
    {
        $this->countTeenager = $countTeenager;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountChild()
    {
        return $this->countChild;
    }

    /**
     * @param int $countChild
     * @return $this
     */
    public function setCountChild($countChild)
    {
        $this->countChild = $countChild;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPax()
    {
        return (int) array_sum([
            $this->getCountAdult(),
            $this->getCountTeenager(),
            $this->getCountChild(),
        ]);
    }

    /**
     * @return string
     */
    public function getTotalPaxDescription()
    {
        $type = [];

        if ($this->getCountAdult()) {
            $type[] = $this->getCountAdult().' Adult';
        }

        if ($this->getCountTeenager()) {
            $type[] = $this->getCountTeenager().' Teenager';
        }

        if ($this->getCountChild()) {
            $type[] = $this->getCountChild().' Child';
        }

        if (empty($type)) {
            throw new \Exception('Type accommodation can not by empty');
        }

        return implode(' / ', $type);
    }

    /**
     * @return TypeRoomAccommodation[]|ArrayCollection
     */
    public function getRoomTypes()
    {
        return $this->roomTypes;
    }

    /**
     * @param TypeRoomAccommodation[]|ArrayCollection $roomTypes
     * @return $this
     */
    public function setRoomTypes($roomTypes)
    {
        $this->roomTypes = $roomTypes;

        return $this;
    }
}

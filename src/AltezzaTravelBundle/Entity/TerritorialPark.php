<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\TerritorialParkRepository")
 * @ORM\Table(name="territorial_park")
 */
class TerritorialPark
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var TerritorialLocation $location
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation", inversedBy="parks")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=false)
     */
    private $location;

    /**
     * @var boolean $isSafariParkCrater
     * @ORM\Column(name="is_crater", type="boolean")
     */
    private $isCrater;

    /**
     * TerritorialPark constructor.
     */
    public function __construct()
    {
        $this->isCrater = false;
    }

    /**
     * @return mixed
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
     * @return TerritorialLocation
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param TerritorialLocation $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCrater(): bool
    {
        return $this->isCrater;
    }

    /**
     * @param bool $isCrater
     * @return $this
     */
    public function setIsCrater(bool $isCrater)
    {
        $this->isCrater = $isCrater;

        return $this;
    }
}

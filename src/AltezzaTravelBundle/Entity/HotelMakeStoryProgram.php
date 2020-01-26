<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelMakeStoryProgramRepository")
 * @ORM\Table(name="hotel_make_story_program")
 */
class HotelMakeStoryProgram
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var HotelMakeStory
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\HotelMakeStory", inversedBy="programs")
     * @ORM\JoinColumn(name="make_story_id", referencedColumnName="id", nullable=false)
     */
    private $makeStory;

    /**
     * @var string $itinerary
     * @ORM\Column(name="itinerary", type="string")
     */
    private $itinerary;

    /**
     * @var string $overnight
     * @ORM\Column(name="overnight", type="string")
     */
    private $overnight;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return HotelMakeStory
     */
    public function getMakeStory()
    {
        return $this->makeStory;
    }

    /**
     * @param HotelMakeStory $makeStory
     */
    public function setMakeStory($makeStory)
    {
        $this->makeStory = $makeStory;
    }

    /**
     * @return string
     */
    public function getItinerary()
    {
        return $this->itinerary;
    }

    /**
     * @param string $itinerary
     */
    public function setItinerary($itinerary)
    {
        $this->itinerary = $itinerary;
    }

    /**
     * @return string
     */
    public function getOvernight()
    {
        return $this->overnight;
    }

    /**
     * @param string $overnight
     */
    public function setOvernight($overnight)
    {
        $this->overnight = $overnight;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}

<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelMakeStoryExtraOptionsRepository")
 * @ORM\Table(name="hotel_make_story_extra_options")
 */
class HotelMakeStoryExtraOptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var HotelMakeStory
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\HotelMakeStory", inversedBy="options")
     * @ORM\JoinColumn(name="make_story_id", referencedColumnName="id", nullable=false)
     */
    private $makeStory;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     * @Gedmo\Timestampable()
     */
    private $date;

    /**
     * @var string $time
     * @ORM\Column(name="time", type="string")
     */
    private $time;

    /**
     * @var string $name
     * @ORM\Column(name="name", type="string")
     */
    private $name;

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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;
}

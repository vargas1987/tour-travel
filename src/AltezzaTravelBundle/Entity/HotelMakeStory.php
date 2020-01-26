<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelMakeStoryRepository")
 * @ORM\Table(name="hotel_make_story")
 */
class HotelMakeStory
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $language
     * @ORM\Column(name="language", type="string", options={"default": "RU"})
     */
    private $language;

    /**
     * @var string $tariff
     * @ORM\Column(name="tariff", type="string")
     */
    private $tariff;

    /**
     * @var string $program
     * @ORM\Column(name="program", type="string")
     */
    private $program;

    /**
     * @var \DateTime
     * @ORM\Column(name="locate_since_at", type="datetime")
     * @Gedmo\Timestampable()
     */
    private $locateSinceAt;


    /**
     * @var \DateTime
     * @ORM\Column(name="locate_end_at", type="datetime")
     * @Gedmo\Timestampable()
     */
    private $locateEndAt;


    /**
     * @var bool $isHideLocateDates
     * @ORM\Column(name="is_hide_locate_dates", type="boolean")
     */
    private $isHideLocateDates;

    /**
     * @var HotelMakeStoryProgram[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelMakeStoryProgram", mappedBy="makeStory", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $programDetails;

    /**
     * @var HotelMakeStoryExtraOptions[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelMakeStoryExtraOptions", mappedBy="makeStory", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $extraOptions;

    public function __construct()
    {
        $this->programDetails = new ArrayCollection();
        $this->extraOptions = new ArrayCollection();
    }

    /**
     * @return HotelMakeStoryExtraOptions[]|ArrayCollection
     */
    public function getExtraOptions()
    {
        return $this->extraOptions;
    }

    /**
     * @param HotelMakeStoryExtraOptions[]|ArrayCollection $extraOptions
     */
    public function setExtraOptions($extraOptions)
    {
        $this->extraOptions = $extraOptions;
    }

    /**
     * @return HotelMakeStoryProgram[]|ArrayCollection
     */
    public function getProgramDetails()
    {
        return $this->programDetails;
    }

    /**
     * @param HotelMakeStoryProgram[]|ArrayCollection $programDetails
     */
    public function setProgramDetails($programDetails)
    {
        $this->programDetails = $programDetails;
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
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return HotelMakeStory
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param string $tariff
     * @return HotelMakeStory
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param string $program
     * @return HotelMakeStory
     */
    public function setProgram($program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLocateSinceAt()
    {
        return $this->locateSinceAt;
    }

    /**
     * @param \DateTime $locateSinceAt
     * @return HotelMakeStory
     */
    public function setLocateSinceAt($locateSinceAt)
    {
        $this->locateSinceAt = $locateSinceAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLocateEndAt()
    {
        return $this->locateEndAt;
    }

    /**
     * @param \DateTime $locateEndAt
     * @return HotelMakeStory
     */
    public function setLocateEndAt($locateEndAt)
    {
        $this->locateEndAt = $locateEndAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideLocateDates()
    {
        return $this->isHideLocateDates;
    }

    /**
     * @param bool $isHideLocateDates
     * @return HotelMakeStory
     */
    public function setIsHideLocateDates($isHideLocateDates)
    {
        $this->isHideLocateDates = $isHideLocateDates;

        return $this;
    }
}

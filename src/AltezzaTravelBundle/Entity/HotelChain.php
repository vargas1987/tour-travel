<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelChainRepository")
 * @ORM\Table(name="hotel_chain")
 */
class HotelChain
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Hotel[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\Hotel", mappedBy="chain")
     */
    private $hotels;

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
     * @return Hotel[]|ArrayCollection
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * @param Hotel[]|ArrayCollection $hotels
     * @return $this
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;

        return $this;
    }
}

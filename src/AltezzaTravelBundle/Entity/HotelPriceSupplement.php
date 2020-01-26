<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelPriceSupplementRepository")
 * @ORM\Table(name="hotel_price_supplement")
 */
class HotelPriceSupplement
{
    use CreateUpdateEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Hotel $hotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="priceSupplements")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var integer $price
     * @ORM\Column(name="price", type="integer", options={"default": 0})
     */
    private $price;

    /**
     * @var \DateTime $dateFrom
     * @ORM\Column(name="date_from", type="date")
     */
    private $dateFrom;

    /**
     * @var \DateTime $dateTo
     * @ORM\Column(name="date_to", type="date")
     */
    private $dateTo;

    /**
     * @var TypeSupplement $type
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeSupplement")
     * @ORM\JoinColumn(name="supplement_type", referencedColumnName="type")
     */
    private $type;

    /**
     * HotelPriceSupplement constructor.
     */
    public function __construct()
    {
        $this->price = 0;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param Hotel $hotel
     * @return $this
     */
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime $dateFrom
     * @return $this
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTime $dateTo
     * @return $this
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @return TypeSupplement
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TypeSupplement $type
     * @return $this
     */
    public function setType(TypeSupplement $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->getDateFrom()
            ? (int) $this->getDateFrom()->format('Y')
            : $this->getDateTo()
                ? (int) $this->getDateTo()->format('Y')
                : date('Y');
    }
}
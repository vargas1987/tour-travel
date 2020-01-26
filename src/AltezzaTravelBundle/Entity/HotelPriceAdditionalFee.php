<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelPriceAdditionalFeeRepository")
 * @ORM\Table(name="hotel_price_additional_fee")
 */
class HotelPriceAdditionalFee
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
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="priceAdditionalFees")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var integer $year
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var integer $price
     * @ORM\Column(name="price", type="integer", options={"default": 0})
     */
    private $price;

    /**
     * @var TypeAdditionalFee $type
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeAdditionalFee")
     * @ORM\JoinColumn(name="additional_fees_type", referencedColumnName="type")
     */
    private $type;

    /**
     * HotelPriceAddiotionalFee constructor.
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
     * @return integer
     */
    public function getYear()
    {
        return (int) $this->year;
    }

    /**
     * @param integer $year
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

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
     * @return TypeAdditionalFee
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TypeAdditionalFee $type
     * @return $this
     */
    public function setType(TypeAdditionalFee $type)
    {
        $this->type = $type;

        return $this;
    }
}
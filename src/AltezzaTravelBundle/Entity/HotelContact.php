<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hotel_contact")
 */
class HotelContact
{
    use CreateUpdateEntity;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Hotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Hotel", inversedBy="contacts")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", nullable=false)
     */
    private $hotel;

    /**
     * @var TypeDepartment
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeDepartment", inversedBy="hotels")
     * @ORM\JoinColumn(name="department_type", referencedColumnName="type", nullable=true)
     */
    private $department;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", nullable=false)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="comment", type="string", nullable=false)
     */
    private $comment;

    /**
     * @return integer
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
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return TypeDepartment
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param TypeDepartment $department
     * @return $this
     */
    public function setDepartment(TypeDepartment $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;

        return $this;
    }
}
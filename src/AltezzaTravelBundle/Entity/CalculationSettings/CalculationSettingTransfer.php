<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use AltezzaTravelBundle\Entity\Settings\TransferTerritorial;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CalculationSettingsTransfer
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingTransferRepository")
 * @ORM\Table(
 *     name="calculation_setting_transfer"
 * )
 */
class CalculationSettingTransfer
{
    const CURRENCY_USD = 'USD';

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var TransferTerritorial
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Settings\TransferTerritorial")
     * @ORM\JoinColumn(name="departure_transfer_territorial_id", referencedColumnName="id", nullable=false)
     */
    private $departureTransferTerritorial;

    /**
     * @var TransferTerritorial
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\Settings\TransferTerritorial")
     * @ORM\JoinColumn(name="arrival_transfer_territorial_id", referencedColumnName="id", nullable=false)
     */
    private $arrivalTransferTerritorial;

    /**
     * @var integer
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TransferTerritorial
     */
    public function getArrivalTransferTerritorial()
    {
        return $this->arrivalTransferTerritorial;
    }

    /**
     * @param TransferTerritorial $arrivalTransferTerritorial
     * @return $this
     */
    public function setArrivalTransferTerritorial($arrivalTransferTerritorial)
    {
        $this->arrivalTransferTerritorial = $arrivalTransferTerritorial;

        return $this;
    }

    /**
     * @return TransferTerritorial
     */
    public function getDepartureTransferTerritorial()
    {
        return $this->departureTransferTerritorial;
    }

    /**
     * @param TransferTerritorial $departureTransferTerritorial
     * @return $this
     */
    public function setDepartureTransferTerritorial($departureTransferTerritorial)
    {
        $this->departureTransferTerritorial = $departureTransferTerritorial;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}
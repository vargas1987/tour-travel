<?php

namespace AltezzaTravelBundle\Entity\CalculationSettings;

use AltezzaTravelBundle\Entity\TerritorialPark;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractCalculationSettingsFee
 * @package AltezzaTravelBundle\Entity\CalculationSetting
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=32)
 * @ORM\DiscriminatorMap({
 *     "feeParkEastAfrican": "CalculationSettingFeeParkEastAfrican",
 *     "feeParkForeinger": "CalculationSettingFeeParkForeigner",
 *     "feeCrater": "CalculationSettingFeeCrater"
 * })
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\CalculationSettingFeeRepository")
 * @ORM\Table(name="calculation_setting_fee")
 */
abstract class AbstractCalculationSettingFee
{
    const CURRENCY_USD = 'USD';
    const CURRENCY_TSH = 'TSH';

    const TYPE_PARK_EAST_AFRICAN = 'PARK_EAST_AFRICAN';
    const TYPE_PARK_FOREIGNER = 'PARK_FOREIGNER';
    const TYPE_CRATER = 'CRATER';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var TerritorialPark $park
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialPark")
     * @ORM\JoinColumn(name="park_id", referencedColumnName="id", nullable=false)
     */
    private $park;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TerritorialPark
     */
    public function getPark()
    {
        return $this->park;
    }

    /**
     * @param TerritorialPark $park
     * @return $this
     */
    public function setPark(TerritorialPark $park)
    {
        $this->park = $park;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType();
}
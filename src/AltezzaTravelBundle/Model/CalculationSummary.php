<?php

namespace AltezzaTravelBundle\Model;

use AltezzaTravelBundle\Doctrine\Common\Collections\ExtensionArrayCollection;
use AltezzaTravelBundle\Entity\AbstractCalculationPerson;
use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class CalculationSummary
 * @package AltezzaTravelBundle\Model
 */
class CalculationSummary
{
    /**
     * @var int
     */
    private $totalSafariDay;

    /**
     * @var int
     */
    private $totalProgramDay;

    /**
     * @var int
     */
    private $totalPax;

    /**
     * @var int
     */
    private $adultPax;

    /**
     * @var int
     */
    private $childPax;

    /**
     * @var int
     */
    private $totalSafariCar;

    /**
     * @var CalculationSummaryPricePerPerson[]
     */
    private $pricePerPersons;

    /**
     * @var float
     */
    private $priceTotal;

    /**
     * @var ExtensionArrayCollection|CalculationResult[]
     */
    private $calculationResults;

    /**
     * CalculationSummary constructor.
     */
    public function __construct()
    {
        $this->pricePerPersons = [];
        $this->calculationResults = new ExtensionArrayCollection();
    }

    /**
     * @return int
     */
    public function getTotalSafariDay()
    {
        return $this->totalSafariDay;
    }

    /**
     * @param int $totalSafariDay
     * @return $this
     */
    public function setTotalSafariDay($totalSafariDay)
    {
        $this->totalSafariDay = $totalSafariDay;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalProgramDay()
    {
        return $this->totalProgramDay;
    }

    /**
     * @param int $totalProgramDay
     * @return $this
     */
    public function setTotalProgramDay($totalProgramDay)
    {
        $this->totalProgramDay = $totalProgramDay;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPax()
    {
        return $this->totalPax;
    }

    /**
     * @param int $totalPax
     * @return $this
     */
    public function setTotalPax($totalPax)
    {
        $this->totalPax = $totalPax;

        return $this;
    }

    /**
     * @return int
     */
    public function getAdultPax()
    {
        return $this->adultPax;
    }

    /**
     * @param int $adultPax
     * @return $this
     */
    public function setAdultPax($adultPax)
    {
        $this->adultPax = $adultPax;

        return $this;
    }

    /**
     * @return int
     */
    public function getChildPax()
    {
        return $this->childPax;
    }

    /**
     * @param int $childPax
     * @return $this
     */
    public function setChildPax($childPax)
    {
        $this->childPax = $childPax;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalSafariCar()
    {
        return $this->totalSafariCar;
    }

    /**
     * @param int $totalSafariCar
     * @return $this
     */
    public function setTotalSafariCar($totalSafariCar)
    {
        $this->totalSafariCar = $totalSafariCar;

        return $this;
    }

    /**
     * @param string $type
     * @return CalculationSummaryPricePerPerson[]|array
     */
    public function getPricePerPersons(string $type = null): array
    {
        if (!$type) {
            return $this->pricePerPersons;
        }

        return array_filter(
            $this->pricePerPersons,
            function (CalculationSummaryPricePerPerson $pricePerPerson) use ($type) {
                return $pricePerPerson->getType() === $type;
            }
        );
    }

    /**
     * @param AbstractCalculationPerson $person
     * @param string                    $type
     * @param float                     $price
     * @return $this
     */
    public function addPricePerPerson(AbstractCalculationPerson $person, string $type, float $price)
    {
        $pricePerPerson = (new CalculationSummaryPricePerPerson())
            ->setPerson($person)
            ->setType($type)
            ->setPrice($price);
        ;

        $this->pricePerPersons[] = $pricePerPerson;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }

    /**
     * @param float $priceTotal
     * @return $this
     */
    public function setPriceTotal($priceTotal)
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    /**
     * @return CalculationResult[]|ExtensionArrayCollection
     */
    public function getCalculationResults()
    {
        return $this->calculationResults;
    }

    /**
     * @return float
     */
    public function getCalculationResultsPrice()
    {
        return array_reduce(
            $this->getCalculationResults()->toArray(),
            function ($result, CalculationResult $calculationResult) {
                $result += $calculationResult->getTotalPrice();

                return $result;
            },
            0
        );
    }

    /**
     * @param CalculationResult[]|ArrayCollection $calculationResults
     * @return $this
     */
    public function setCalculationResults($calculationResults)
    {
        $this->calculationResults = $calculationResults;

        return $this;
    }

    /**
     * @param CalculationResult $calculationResult
     * @return $this
     */
    public function addCalculationResult(CalculationResult $calculationResult)
    {
        $this->calculationResults->add($calculationResult);

        return $this;
    }

    /**
     * @param string|array $blocks
     * @param bool         $isGrouped
     * @return CalculationResult[]|ExtensionArrayCollection|array
     */
    public function getCalculationResultsByBlocks($blocks, $isGrouped = false)
    {
        if (\is_string($blocks)) {
            $blocks = [$blocks];
        }

        /** @var ExtensionArrayCollection| $calculationResults */
        $calculationResults = $this->getCalculationResults()->filter(function (CalculationResult $calculationResult) use ($blocks) {
            return \in_array($calculationResult->getBlock(), $blocks, true);
        });

        if ($isGrouped) {
            return $calculationResults->reduce(
                function ($result, CalculationResult $calculationResult) {
                    $result[$calculationResult->getGroup()][] = $calculationResult;

                    return $result;
                },
                []
            );
        }

        return $calculationResults;
    }
}
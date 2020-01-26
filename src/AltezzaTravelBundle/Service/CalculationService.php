<?php

namespace AltezzaTravelBundle\Service;

use AltezzaTravelBundle\Entity\AbstractCalculationNight;
use AltezzaTravelBundle\Entity\AbstractCalculationPerson;
use AltezzaTravelBundle\Entity\Calculation;
use AltezzaTravelBundle\Entity\CalculationFlight;
use AltezzaTravelBundle\Entity\CalculationNightSafari;
use AltezzaTravelBundle\Entity\CalculationNightZanzibar;
use AltezzaTravelBundle\Entity\CalculationPersonAdult;
use AltezzaTravelBundle\Entity\CalculationPersonChild;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCarRental;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCurrencyRate;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeCrater;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkEastAfrican;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkForeigner;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingOther;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingTransfer;
use AltezzaTravelBundle\Entity\CalculationTransfer;
use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TerritorialPark;
use AltezzaTravelBundle\Exception\HotelPriceByDateNotExistException;
use AltezzaTravelBundle\Exception\HotelSeasonByDateNotExistException;
use AltezzaTravelBundle\Helper\CalculationHelper;
use AltezzaTravelBundle\Helper\HotelPickUpHelper;
use AltezzaTravelBundle\Model\CalculationResult;
use AltezzaTravelBundle\Model\CalculationResultPricePerPerson;
use AltezzaTravelBundle\Model\CalculationSummary;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CalculationService
 * @package AltezzaTravelBundle\Service
 */
class CalculationService
{
    const TRANSFER_MAX_PAX = 3;
    const CAR_RENTAL_MAX_PAX = 5;

    const TRANSFER_MIN_PRICE = 30;
    const CAR_RENTAL_MIN_PRICE = 200;
    const ACCOMMODATION_MIN_PRICE = 50;

    const PERSON_MIN_ADULT_AGE = 16;

    const PARK_FEE_PERSON_MIN_CHILD_AGE = 5;
    const PARK_FEE_FOREIGN_ADULT_PRICE_MIN = 45;
    const PARK_FEE_FOREIGN_CHILD_PRICE_MIN = 15;
    const PARK_FEE_EAST_AFRICAN_ADULT_PRICE_MIN = 4;
    const PARK_FEE_EAST_AFRICAN_CHILD_PRICE_MIN = 1;
    const PARK_FEE_VAT = 18;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var HotelPickUpHelper $hotelPickUpHelper */
    private $hotelPickUpHelper;

    /** @var CalculationHelper $calculationHelper */
    private $calculationHelper;

    /**
     * CalculationService constructor.
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $entityManager
     * @param HotelPickUpHelper      $hotelPickUpHelper
     * @param CalculationHelper      $calculationHelper
     */
    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        HotelPickUpHelper $hotelPickUpHelper,
        CalculationHelper $calculationHelper
    ) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->hotelPickUpHelper = $hotelPickUpHelper;
        $this->calculationHelper = $calculationHelper;
    }

    /**
     * @param CalculationTransfer $transfer
     * @return CalculationResult
     */
    public function calculateTransfer(CalculationTransfer $transfer)
    {
        $result = new CalculationResult();
        $result
            ->setBlock(CalculationResult::BLOCK_TRANSFERS)
            ->setDescription($transfer->getDeparture()->getTitle().' - '.$transfer->getArrival()->getTitle())
            ->setPax($transfer->getTotalPax())
            ->setStatus(CalculationResult::STATUS_SUCCESS)
        ;

        try {
            $transferPrice = $this->entityManager->getRepository(CalculationSettingTransfer::class)->getPriceByTransfer($transfer);
            if (!$transferPrice) {
                $result->setStatus(CalculationResult::STATUS_DANGER);

                return $result;
            }

            $transferRate = (int) ceil($transfer->getTotalPax() / self::TRANSFER_MAX_PAX);
            $result->setPrice($transferPrice->getPrice() * $transferRate);

            if ($result->getPrice() <= self::TRANSFER_MIN_PRICE) {
                $result->setStatus(CalculationResult::STATUS_WARNING);
            }
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            // @TODO
            $result->setStatus(CalculationResult::STATUS_DANGER);
        }

        return $result;
    }

    /**
     * @param int $totalPax
     * @param int $safariDays
     * @return CalculationResult
     */
    public function calculateCarRental(int $totalPax, int $safariDays)
    {
        $result = new CalculationResult();
        $result
            ->setBlock(CalculationResult::BLOCK_TRANSFERS)
            ->setDescription('Rent safari car')
            ->setPax($totalPax)
            ->setStatus(CalculationResult::STATUS_SUCCESS)
        ;

        try {
            $carRentalPrice = $this->entityManager->getRepository(CalculationSettingCarRental::class)->getPriceByCountDays($safariDays);
            if (!$carRentalPrice) {
                $result->setStatus(CalculationResult::STATUS_DANGER);

                return $result;
            }

            $carRentalRate = (int) ceil($totalPax / self::CAR_RENTAL_MAX_PAX);
            $result->setPrice($carRentalPrice->getPrice() * $carRentalRate * $safariDays);

            if ($result->getPrice() <= self::CAR_RENTAL_MIN_PRICE) {
                $result->setStatus(CalculationResult::STATUS_WARNING);
            }
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            // @TODO
            $result->setStatus(CalculationResult::STATUS_DANGER);
        }

        return $result;
    }

    /**
     * @param AbstractCalculationNight $night
     * @param Hotel                    $hotel
     * @return CalculationResult
     * @throws \Exception
     */
    public function calculateAccommodation(AbstractCalculationNight $night, Hotel $hotel)
    {
        $result = new CalculationResult();
        $result
            ->setBlock(CalculationResult::BLOCK_ACCOMMODATION)
            ->setDescription(sprintf(
                '%s (%s / %s)',
                $night->getRoom()->getTitle(true),
                $night->getAccommodation()->getTotalPaxDescription(),
                $night->getMealPlanType()->getTitle()
            ))
            ->setPax($night->getAccommodation()->getTotalPax())
            ->setGroup($hotel->getTitle())
            ->addOption('count', $night->getCount())
            ->setStatus(CalculationResult::STATUS_SUCCESS);
        ;

        switch ($night->getType()) {
            case AbstractCalculationNight::TYPE_SAFARI:
                /** @var CalculationNightSafari $night */
                $dateFrom = clone $night->getCalculation()->getDateFrom();
                $dateFrom->modify(sprintf('+%s day', $night->getNight() - 1));
                $dateTo = clone $dateFrom;
                $dateTo->modify('+1 day');
                break;
            case AbstractCalculationNight::TYPE_ZANZIBAR:
                /** @var CalculationNightZanzibar $night */
                $dateFrom = clone $night->getCalculation()->getDateFrom();
                $dateFrom->modify(sprintf('+%s day', $night->getNightFrom() - 1));
                $dateTo = clone $dateFrom;
                $dateTo->modify(sprintf('+%s day', $night->getNightTo() - ($night->getNightFrom() - 1)));
                break;
            default:
                throw new \Exception('Undefined calculation night type');
        }

        try {
            $price = $this->hotelPickUpHelper->calculateFullAccommodationPrice(
                $night->getHotel(),
                $night->getRoom(),
                $night->getMealPlanType(),
                $night->getAccommodation(),
                $dateFrom,
                $dateTo
            );

            $result->setPrice($price * $night->getCount());

            if ($result->getPrice() <= self::ACCOMMODATION_MIN_PRICE) {
                $result->setStatus(CalculationResult::STATUS_WARNING);
            }

            if (empty($result->getPrice())) {
                $result->setStatus(CalculationResult::STATUS_DANGER);
            }
        } catch (HotelPriceByDateNotExistException $exception) {
            $result->setStatus(CalculationResult::STATUS_DANGER);
        } catch (HotelSeasonByDateNotExistException $exception) {
            $result->setStatus(CalculationResult::STATUS_DANGER);
        }

        return $result;
    }

    /**
     * @param Calculation         $calculation
     * @param TerritorialPark $park
     * @param int                 $countDays
     * @return CalculationResult
     */
    public function calculateParkFee(Calculation $calculation, TerritorialPark $park, int $countDays)
    {
        $countCars = (int) ceil($calculation->getTotalPax() / self::CAR_RENTAL_MAX_PAX);

        $result = new CalculationResult();
        $result
            ->setBlock(CalculationResult::BLOCK_PARK_FEES)
            ->setDescription(sprintf('%s (%s Day%s)', $park->getTitle(), $countDays, ($countDays > 1 ? 's' : '')))
            ->setPax($calculation->getTotalPax())
            ->setGroup($park->getTitle())
            ->setStatus(CalculationResult::STATUS_SUCCESS);
        ;

        try {
            $repositoryForeigner = $this->entityManager->getRepository(CalculationSettingFeeParkForeigner::class);
            $repositoryEastAfrican = $this->entityManager->getRepository(CalculationSettingFeeParkEastAfrican::class);
            $repositoryCrater = $this->entityManager->getRepository(CalculationSettingFeeCrater::class);

            $parkForeignerPrice = $repositoryForeigner->getPriceByPark($park);
            $parkEastAfricanPrice = $repositoryEastAfrican->getPriceByPark($park);
            $parkCraterPrice = $repositoryCrater->getPriceByPark($park);

            if (!$parkEastAfricanPrice) {
                $result->setStatus(CalculationResult::STATUS_DANGER);

                return $result;
            }

            $parkPrice = 0;

            $carPriceUsd = $this->convertPrice((float) $parkEastAfricanPrice->getCar(), CalculationSettingCurrencyRate::CURRENCY_TSH, CalculationSettingCurrencyRate::CURRENCY_USD);
            $parkPrice += $countCars * $countDays * $carPriceUsd;
            $driverPriceUsd = $this->convertPrice((float) $parkEastAfricanPrice->getDriver(), CalculationSettingCurrencyRate::CURRENCY_TSH, CalculationSettingCurrencyRate::CURRENCY_USD);
            $parkPrice += $countCars * $countDays * $driverPriceUsd;

            $incorrectPrice = false;
            if ($calculation->isForeigners()) {
                $adultPriceUsd = $parkForeignerPrice->getAdult();
                $childPriceUsd = $parkForeignerPrice->getChild();

                $incorrectPrice = $incorrectPrice || $adultPriceUsd < self::PARK_FEE_FOREIGN_ADULT_PRICE_MIN;
                $incorrectPrice = $incorrectPrice || $childPriceUsd < self::PARK_FEE_FOREIGN_CHILD_PRICE_MIN;
            } else {
                $adultPriceUsd = $this->convertPrice((float) $parkEastAfricanPrice->getAdult(), CalculationSettingCurrencyRate::CURRENCY_TSH, CalculationSettingCurrencyRate::CURRENCY_USD);
                $childPriceUsd = $this->convertPrice((float) $parkEastAfricanPrice->getChild(), CalculationSettingCurrencyRate::CURRENCY_TSH, CalculationSettingCurrencyRate::CURRENCY_USD);

                $incorrectPrice = $incorrectPrice || $adultPriceUsd < self::PARK_FEE_EAST_AFRICAN_ADULT_PRICE_MIN;
                $incorrectPrice = $incorrectPrice || $childPriceUsd < self::PARK_FEE_EAST_AFRICAN_CHILD_PRICE_MIN;
            }

            if ($parkCraterPrice) {
                if ($calculation->isForeigners()) {
                    $craterPriceUsd = $parkCraterPrice->getPriceUsd();
                } else {
                    $craterPriceUsd = $this->convertPrice((float) $parkCraterPrice->getPriceTsh(), CalculationSettingCurrencyRate::CURRENCY_TSH, CalculationSettingCurrencyRate::CURRENCY_USD);
                }

                $parkPrice += $countDays * $craterPriceUsd * $countCars;
            }

            $calculation->getPersons()->map(
                function (AbstractCalculationPerson $person)
                use ($result, $countDays, $adultPriceUsd, $childPriceUsd) {
                    $pricePerPerson = new CalculationResultPricePerPerson();
                    $pricePerPerson->setPerson($person);

                    switch (true) {
                        case ($person instanceof CalculationPersonAdult):
                        case ($person instanceof CalculationPersonChild)  && $person->getAge() >= self::PERSON_MIN_ADULT_AGE:
                            $price = $countDays * $adultPriceUsd;
                            $price += $price / 100 * self::PARK_FEE_VAT;

                            $pricePerPerson
                                ->setType(AbstractCalculationPerson::TYPE_ADULT)
                                ->setPrice($price)
                            ;
                            break;
                        case ($person instanceof CalculationPersonChild) && $person->getAge() >= self::PARK_FEE_PERSON_MIN_CHILD_AGE:
                            $price = $countDays * $childPriceUsd;
                            $price += $price / 100 * self::PARK_FEE_VAT;

                            $pricePerPerson
                                ->setType(AbstractCalculationPerson::TYPE_CHILD)
                                ->setPrice($price)
                            ;
                            break;
                        default:
                            $pricePerPerson
                                ->setType(AbstractCalculationPerson::TYPE_CHILD)
                                ->setPrice(0)
                            ;
                    }

                    $result->addPricePerPerson($pricePerPerson);
                }
            );

            $parkPrice += $parkPrice / 100 * self::PARK_FEE_VAT;

            $result->setPrice($parkPrice);

            if ($incorrectPrice) {
                $result->setStatus(CalculationResult::STATUS_WARNING);
            }
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            // @TODO
            $result->setStatus(CalculationResult::STATUS_DANGER);
        }

        return $result;
    }

    /**
     * @param Calculation             $calculation
     * @param CalculationSettingOther $expense
     * @return CalculationResult
     */
    public function calculateOther(Calculation $calculation, CalculationSettingOther $expense)
    {
        $result = new CalculationResult();
        $result
            ->setBlock(CalculationResult::BLOCK_OTHER)
            ->setDescription($expense->getTitle())
            ->setStatus(CalculationResult::STATUS_SUCCESS)
        ;

        try {
            $price = $expense->getPrice();
            if ($expense->isPerSafariDay()) {
                $price = $price * $calculation->getCountSafariDays();
            }
            if ($expense->isPerPerson()) {
                $price = $price * $calculation->getTotalPax();
            }
            $result->setPrice($price);
        } catch (\Throwable $exception) {
            $result->setStatus(CalculationResult::STATUS_DANGER);
        }

        return $result;
    }

    /**
     * @param Calculation $calculation
     * @param $price
     * @return CalculationResult
     */
    public function calculateOurCommission(Calculation $calculation, $price)
    {
        $result = new CalculationResult();
        $result
            ->setBlock(CalculationResult::BLOCK_OUR_COMMISSION)
            ->setDescription('Our commission ('.$calculation->getOurCommission().'%)')
            ->setPrice($price / 100 * $calculation->getOurCommission())
            ->setStatus(CalculationResult::STATUS_SUCCESS);
        ;

        return $result;
    }

    /**
     * @param Calculation $calculation
     * @return CalculationSummary
     */
    public function calculateSummary(Calculation $calculation)
    {
        $summary = new CalculationSummary();

        $totalSafariDay = $calculation->getCountSafariDays();
        $totalSafariCar = 0;
        if ($totalSafariDay) {
            $totalSafariCar = (int) ceil($calculation->getTotalPax() / self::CAR_RENTAL_MAX_PAX);
        }

        $calculation->getTransfers()->map(function (CalculationTransfer $transfer) use ($summary) {
            $summary->addCalculationResult($this->calculateTransfer($transfer));
        });
        $summary->addCalculationResult($this->calculateCarRental($calculation->getTotalPax(), $totalSafariDay));

//      @TODO calculate flight
//        $calculation->getFlights()->map(function (CalculationFlight $flight) use ($summary) {
//            $summary->addCalculationResult($this->calculateTransfer($flight));
//        });

        array_map(
            function ($item) use ($calculation, $summary) {
                /** @var TerritorialPark $park */
                $park = $item['park'];
                /** @var int $days */
                $days = $item['days'];

                $parkFee = $this->calculateParkFee($calculation, $park, $days);
                $summary->addCalculationResult($parkFee);
            },
            $this->calculationHelper->getDaysGroupsByLocation($calculation)
        );

        array_map(
            function ($item) use ($summary) {
                /** @var Hotel $hotel */
                $hotel = $item['hotel'];
                /** @var AbstractCalculationNight[] $nights */
                $nights = $item['nights'];
                foreach ($nights as $night) {
                    $accommodation = $this->calculateAccommodation($night, $hotel);
                    $summary->addCalculationResult($accommodation);
                }
            },
            $this->calculationHelper->getNightsGroupsByHotel($calculation)
        );

        $otherExpenses = $this->entityManager->getRepository(CalculationSettingOther::class)->findAll();
        foreach ($otherExpenses as $expense) {
            $summary->addCalculationResult($this->calculateOther($calculation, $expense));
        }

        $adultPax = $calculation->getChildPersons()->filter(function (CalculationPersonChild $personChild) {
                return $personChild->getAge() >= self::PERSON_MIN_ADULT_AGE;
            })->count() + $calculation->getAdultPax();
        $childPax = $calculation->getChildPersons()->filter(function (CalculationPersonChild $personChild) {
                return $personChild->getAge() < self::PERSON_MIN_ADULT_AGE;
            })->count();

        $summary
            ->setTotalSafariDay($totalSafariDay)
            ->setTotalProgramDay($calculation->getTotalProgramDays())
            ->setTotalPax($calculation->getTotalPax())
            ->setAdultPax($adultPax)
            ->setChildPax($childPax)
            ->setTotalSafariCar($totalSafariCar)
        ;

        $priceWithoutOurCommission = $summary->getCalculationResultsPrice();
        $summary->addCalculationResult($this->calculateOurCommission($calculation, $priceWithoutOurCommission));

        $priceTransferType = array_reduce(
            $summary->getCalculationResultsByBlocks([
                CalculationResult::BLOCK_TRANSFERS,
                CalculationResult::BLOCK_PARK_FEES,
            ])->toArray(),
            function ($result, CalculationResult $calculationResult) {
                switch ($calculationResult->getBlock()) {
                    case CalculationResult::BLOCK_PARK_FEES:
                        $result += $calculationResult->getPrice();
                        break;
                    default:
                        $result += $calculationResult->getTotalPrice();
                }

                return $result;
            },
            0
        );

        $priceAdultType = array_reduce(
            $summary->getCalculationResultsByBlocks([
                CalculationResult::BLOCK_PARK_FEES,
                CalculationResult::BLOCK_FLIGHT_TICKETS,
                CalculationResult::BLOCK_ACCOMMODATION,
                CalculationResult::BLOCK_OTHER,
                CalculationResult::BLOCK_OUR_COMMISSION,
            ])->toArray(),
            function ($result, CalculationResult $calculationResult) {
                switch ($calculationResult->getBlock()) {
                    case CalculationResult::BLOCK_PARK_FEES:
                    case CalculationResult::BLOCK_FLIGHT_TICKETS:
                        $result += $calculationResult->getPriceAdult();
                        break;
                    default:
                        $result += $calculationResult->getPrice();
                }

                return $result;
            },
            0
        );

        $summary->addPricePerPerson(
            $calculation->getAdultPersons()->first(),
            AbstractCalculationPerson::TYPE_ADULT,
            ($priceAdultType / $adultPax) + ($priceTransferType / $calculation->getTotalPax())
        );

        $calculation->getChildPersons()->map(
            function (CalculationPersonChild $child)
            use ($summary, $priceTransferType) {
                if ($child->getAge() >= self::PERSON_MIN_ADULT_AGE) {
                    return;
                }

                $priceChildType = array_reduce(
                    $summary->getCalculationResultsByBlocks([
                        CalculationResult::BLOCK_PARK_FEES,
                        CalculationResult::BLOCK_FLIGHT_TICKETS,
                    ])->toArray(),
                    function ($result, CalculationResult $calculationResult) use ($child) {
                        if ($priceForPerson = $calculationResult->getPriceByPerson($child)) {
                            $result += $priceForPerson->getTotalPrice();
                        }

                        return $result;
                    },
                    0
                );

                $summary->addPricePerPerson(
                    $child,
                    AbstractCalculationPerson::TYPE_CHILD,
                    $priceChildType + ($priceTransferType / $summary->getTotalPax())
                );

            }
        );

        $summary->setPriceTotal($summary->getCalculationResultsPrice());

        return $summary;
    }

    /**
     * @param float  $price
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float|int
     */
    private function convertPrice(float $price, string $currencyFrom, string $currencyTo)
    {
        /** @var CalculationSettingCurrencyRate $rate */
        $rate = $this->entityManager->getRepository(CalculationSettingCurrencyRate::class)
            ->getLastRate($currencyFrom, $currencyTo);

        return $price * $rate->getValueTo() / $rate->getValueFrom();
    }
}

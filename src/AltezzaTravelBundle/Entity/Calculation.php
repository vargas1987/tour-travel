<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calculation")
 */
class Calculation
{
    use CreateUpdateEntity;

    const CALCULATION_STATUS_DRAFT = 'draft';

    const CALCULATION_STATUS_TEMPLATE = 'template';

    const OUR_COMMISSION_PERCENT = 35;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * @var \DateTime $dateFrom
     * @ORM\Column(name="date_from", type="date", nullable=false)
     */
    private $dateFrom;

    /**
     * @var \DateTime $dateTo
     * @ORM\Column(name="date_to", type="date", nullable=false)
     */
    private $dateTo;

    /**
     * @var CalculationFlight[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\CalculationFlight", mappedBy="calculation", orphanRemoval=true, cascade={"persist"})
     */
    private $flights;

    /**
     * @var CalculationFlight[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\CalculationTransfer", mappedBy="calculation", orphanRemoval=true, cascade={"persist"})
     */
    private $transfers;

    /**
     * @var boolean
     * @ORM\Column(name="foreigners", type="boolean")
     */
    private $foreigners;

    /**
     * @var AbstractCalculationPerson[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AbstractCalculationPerson", mappedBy="calculation", orphanRemoval=true, cascade={"persist"})
     */
    private $persons;

    /**
     * @var AbstractCalculationNight[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\AbstractCalculationNight", mappedBy="calculation", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"hotel": "ASC"})
     */
    private $nights;

    /**
     * @var AbstractCalculationDay[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\AbstractCalculationDay", mappedBy="calculation", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $days;

    /**
     * @var int
     * @ORM\Column(name="count_safari_days", type="integer", nullable=false)
     */
    private $countSafariDays;

    /**
     * @var float
     * @ORM\Column(name="our_commission", type="float", nullable=false, options={"default": "35.00"})
     */
    private $ourCommission;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;

    /**
     * Calculation constructor.
     */
    public function __construct()
    {
        $this->title = '';
        $this->transfers = new ArrayCollection();
        $this->flights = new ArrayCollection();
        $this->foreigners = true;
        $this->persons = new ArrayCollection();
        $this->nights = new ArrayCollection();
        $this->days = new ArrayCollection();
        $this->countSafariDays = 0;
        $this->ourCommission = self::OUR_COMMISSION_PERCENT;
        $this->status = self::CALCULATION_STATUS_DRAFT;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        if ($this->getStatus() === self::CALCULATION_STATUS_DRAFT) {
            return $this->getId() ? 'Draft #'.$this->getId() : 'New Draft';
        }

        return $this->title;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
    public function setDateFrom(\DateTime $dateFrom)
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
    public function setDateTo(\DateTime $dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @return bool|\DateInterval|null
     */
    public function getDateInterval()
    {
        if (!$this->getDateFrom() || !$this->getDateTo()) {
            return null;
        }

        return $this->getDateFrom()->diff($this->getDateTo());
    }

    /**
     * @return int
     */
    public function getTotalProgramDays()
    {
        if ($interval = $this->getDateInterval()) {
            return (int) $interval->format('%a') + 1;
        }

        return 0;
    }

    /**
     * @return CalculationFlight[]|ArrayCollection
     */
    public function getFlights()
    {
        return $this->flights;
    }

    /**
     * @param CalculationFlight[]|ArrayCollection $flights
     * @return $this
     */
    public function setFlights($flights)
    {
        $this->flights = $flights;

        return $this;
    }

    /**
     * @param CalculationFlight $flight
     * @return $this
     */
    public function addFlight(CalculationFlight $flight)
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
            $flight->setCalculation($this);
        }

        return $this;
    }

    /**
     * @param CalculationFlight $flight
     * @return $this
     */
    public function removeFlight(CalculationFlight $flight)
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
        }

        return $this;
    }

    /**
     * @return CalculationTransfer[]|ArrayCollection
     */
    public function getTransfers()
    {
        return $this->transfers;
    }

    /**
     * @param CalculationTransfer[]|ArrayCollection $transfers
     * @return $this
     */
    public function setTransfers($transfers)
    {
        $this->transfers = $transfers;

        return $this;
    }

    /**
     * @param CalculationTransfer $transfer
     * @return $this
     */
    public function addTransfer(CalculationTransfer $transfer)
    {
        if (!$this->transfers->contains($transfer)) {
            $this->transfers->add($transfer);
            $transfer->setCalculation($this);
        }

        return $this;
    }

    /**
     * @param CalculationTransfer $transfer
     * @return $this
     */
    public function removeTransfer(CalculationTransfer $transfer)
    {
        if ($this->transfers->contains($transfer)) {
            $this->transfers->removeElement($transfer);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isForeigners(): bool
    {
        return $this->foreigners;
    }

    /**
     * @param bool $foreigners
     * @return $this
     */
    public function setForeigners(bool $foreigners)
    {
        $this->foreigners = $foreigners;

        return $this;
    }

    /**
     * @return AbstractCalculationPerson[]|ArrayCollection
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * @param AbstractCalculationPerson[]|ArrayCollection $persons
     * @return $this
     */
    public function setPersons($persons)
    {
        $this->persons = $persons;

        return $this;
    }

    /**
     * @return CalculationPersonAdult[]|ArrayCollection
     */
    public function getAdultPersons()
    {
        return $this->persons->filter(function (AbstractCalculationPerson $person) {
            return $person->getType() === AbstractCalculationPerson::TYPE_ADULT;
        });
    }

    /**
     * @param CalculationPersonAdult[] $persons
     * @return $this
     */
    public function setAdultPersons($persons)
    {
        foreach ($persons as $person) {
            if ($this->persons->contains($person)) {
                continue;
            }

            $this->persons->add($person);
            $person->setCalculation($this);
        }

        return $this;
    }

    /**
     * @param CalculationPersonAdult $person
     * @return $this
     */
    public function addAdultPerson(CalculationPersonAdult $person)
    {
        if (!$this->persons->contains($person)) {
            $person->setCalculation($this);
            $this->persons->add($person);
        }

        return $this;
    }

    /**
     * @param CalculationPersonAdult $person
     * @return $this
     */
    public function removeAdultPerson(CalculationPersonAdult $person)
    {
        if ($this->persons->contains($person)) {
            $this->persons->removeElement($person);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|CalculationPersonChild[]
     */
    public function getChildPersons()
    {
        return $this->persons->filter(function (AbstractCalculationPerson $person) {
            return $person->getType() === AbstractCalculationPerson::TYPE_CHILD;
        });
    }

    /**
     * @param AbstractCalculationPerson[]|ArrayCollection $persons
     * @return $this
     */
    public function setChildPersons($persons)
    {
        foreach ($persons as $person) {
            if ($this->persons->contains($person)) {
                continue;
            }

            $this->persons->add($person);
            $person->setCalculation($this);
        }

        return $this;
    }

    /**
     * @param CalculationPersonChild $person
     * @return $this
     * @return $this
     */
    public function addChildPerson(CalculationPersonChild $person)
    {
        if (!$this->persons->contains($person)) {
            $person->setCalculation($this);
            $this->persons->add($person);
        }

        return $this;
    }

    /**
     * @param CalculationPersonChild $person
     * @return $this
     */
    public function removeChildPerson(CalculationPersonChild $person)
    {
        if ($this->persons->contains($person)) {
            $this->persons->removeElement($person);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getAdultPax()
    {
        return array_reduce(
            $this->getAdultPersons()->toArray(),
            function ($result, CalculationPersonAdult $person) {
                $result += $person->getCount();

                return $result;
            },
            0
        );
    }

    /**
     * @return int
     */
    public function getChildPax()
    {
        return $this->getChildPersons()->count();
    }

    /**
     * @return int
     */
    public function getTotalPax()
    {
        return $this->getAdultPax() + $this->getChildPax();
    }

    /**
     * @return AbstractCalculationNight[]|ArrayCollection
     */
    public function getNights()
    {
        return $this->nights;
    }

    /**
     * @param AbstractCalculationNight[]|ArrayCollection $nights
     * @return $this
     */
    public function setNights($nights)
    {
        $this->nights = $nights;

        return $this;
    }

    /**
     * @return ArrayCollection|AbstractCalculationNight[]
     */
    public function getSafariNights()
    {
        return $this->getNightsByType(AbstractCalculationNight::TYPE_SAFARI);
    }

    /**
     * @param AbstractCalculationNight[]|ArrayCollection $nights
     * @return $this
     */
    public function setSafariNights($nights)
    {
        $safariNights = $this->getSafariNights();
        foreach ($safariNights as $night) {
            $this->removeNight($night);
        }
        foreach ($nights as $night) {
            $this->addNight($night);
        }

        return $this;
    }

    /**
     * @param AbstractCalculationNight $night
     * @return $this
     */
    public function addSafariNight($night)
    {
        $this->addNight($night);

        return $this;
    }

    /**
     * @param AbstractCalculationNight $night
     * @return $this
     */
    public function removeSafariNight($night)
    {
        $this->removeNight($night);

        return $this;
    }

    /**
     * @param $type
     * @return ArrayCollection|AbstractCalculationNight[]
     */
    public function getZanzibarNights()
    {
        return $this->getNightsByType(AbstractCalculationNight::TYPE_ZANZIBAR);
    }

    /**
     * @param AbstractCalculationNight[]|ArrayCollection $nights
     * @return $this
     */
    public function setZanzibarNights($nights)
    {
        $zanzibarNights = $this->getZanzibarNights();
        foreach ($zanzibarNights as $night) {
            $this->removeNight($night);
        }
        foreach ($nights as $night) {
            $this->addNight($night);
        }

        return $this;
    }

    /**
     * @param AbstractCalculationNight $night
     * @return $this
     */
    public function addZanzibarNight($night)
    {
        $this->addNight($night);

        return $this;
    }

    /**
     * @param AbstractCalculationNight $night
     * @return $this
     */
    public function removeZanzibarNight($night)
    {
        $this->removeNight($night);

        return $this;
    }

    /**
     * @param $type
     * @return ArrayCollection|AbstractCalculationNight[]
     */
    public function getNightsByType($type)
    {
        return $this->nights->filter(function (AbstractCalculationNight $night) use ($type) {
            return $night->getType() === $type;
        });
    }

    /**
     * @param AbstractCalculationNight $night
     * @return $this
     */
    public function addNight(AbstractCalculationNight $night)
    {
        if (!$this->nights->contains($night)) {
            $this->nights->add($night);
            $night->setCalculation($this);
        }

        return $this;
    }

    /**
     * @param AbstractCalculationNight $night
     * @return $this
     */
    public function removeNight(AbstractCalculationNight $night)
    {
        if ($this->nights->contains($night)) {
            $this->nights->removeElement($night);
        }

        return $this;
    }

    /**
     * @return AbstractCalculationDay[]|ArrayCollection
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param AbstractCalculationDay[]|ArrayCollection $days
     * @return $this
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * @param $type
     * @return ArrayCollection|AbstractCalculationDay[]
     */
    public function getSafariDays()
    {
        return $this->getDaysByType(AbstractCalculationDay::TYPE_SAFARI);
    }

    /**
     * @param AbstractCalculationDay[]|ArrayCollection $days
     * @return $this
     */
    public function setSafariDays($days)
    {
        $safariDays = $this->getSafariDays();
        foreach ($safariDays as $day) {
            $this->removeDay($day);
        }
        foreach ($days as $day) {
            $this->addDay($day);
        }

        return $this;
    }

    /**
     * @param AbstractCalculationDay $day
     * @return $this
     */
    public function addSafariDay($day)
    {
        $this->addDay($day);

        return $this;
    }

    /**
     * @param AbstractCalculationDay $day
     * @return $this
     */
    public function removeSafariDay($day)
    {
        $this->removeDay($day);

        return $this;
    }

    /**
     * @param $type
     * @return ArrayCollection|AbstractCalculationDay[]
     */
    public function getDaysByType($type)
    {
        return $this->days->filter(function (AbstractCalculationDay $day) use ($type) {
            return $day->getType() === $type;
        });
    }

    /**
     * @param AbstractCalculationDay $day
     * @return $this
     */
    public function addDay(AbstractCalculationDay $day)
    {
        if (!$this->days->contains($day)) {
            $this->days->add($day);
            $day->setCalculation($this);
        }

        return $this;
    }

    /**
     * @param AbstractCalculationDay $day
     * @return $this
     */
    public function removeDay(AbstractCalculationDay $day)
    {
        if ($this->days->contains($day)) {
            $this->days->removeElement($day);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCountSafariDays()
    {
        return $this->countSafariDays;
    }

    /**
     * @param int $countSafariDays
     * @return $this
     */
    public function setCountSafariDays(int $countSafariDays)
    {
        $this->countSafariDays = $countSafariDays;

        return $this;
    }

    /**
     * @return float
     */
    public function getOurCommission(): float
    {
        return $this->ourCommission;
    }

    /**
     * @param float $ourCommission
     */
    public function setOurCommission(float $ourCommission)
    {
        $this->ourCommission = $ourCommission;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }
}

<?php

namespace AltezzaTravelBundle\Entity;

use AltezzaTravelBundle\Entity\Traits\CreateUpdateEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AltezzaTravelBundle\Repository\HotelRepository")
 * @ORM\Table(name="hotel")
 */
class Hotel
{
    use CreateUpdateEntity;

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="ratio", type="integer", nullable=false, options={"default": 0})
     */
    private $ratio;

    /**
     * @var TypeHotel
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TypeHotel", inversedBy="hotels")
     * @ORM\JoinColumn(name="type_hotel", referencedColumnName="type", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(name="title", type="string", nullable=false, unique=true)
     */
    private $title;

    /**
     * @var HotelChain $chain
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\HotelChain", inversedBy="hotels")
     * @ORM\JoinColumn(name="chain_id", referencedColumnName="id", nullable=true)
     * @ORM\OrderBy({"title": "ASC"})
     */
    private $chain;

    /**
     * @var TypeMealPlan[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AltezzaTravelBundle\Entity\TypeMealPlan", inversedBy="hotels", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="hotel_type_of_meal",
     *     joinColumns={@ORM\JoinColumn(name="hotel_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="meal_plan_type", referencedColumnName="type")}
     * )
     * @ORM\OrderBy({"sort": "ASC"})
     */
    private $mealPlans;

    /**
     * @var TerritorialLocation $location
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialLocation")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=false)
     */
    private $location;

    /**
     * @var TerritorialArea $area
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialArea", inversedBy="hotels")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id", nullable=true)
     */
    private $area;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AltezzaTravelBundle\Entity\TerritorialAirstrip", inversedBy="hotels")
     * @ORM\JoinColumn(name="airstrip_id", referencedColumnName="id", nullable=true)
     */
    private $airstrip;

    /**
     * @var integer $timeToAirstrip
     * @ORM\Column(name="time_to_airstrip", type="integer", nullable=true)
     */
    private $timeToAirstrip;

    /**
     * @var boolean $isMobileCamp
     * @ORM\Column(name="is_mobile_camp", type="boolean")
     */
    private $isMobileCamp;

    /**
     * @var HotelMobileCamp[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelMobileCamp", mappedBy="hotel", orphanRemoval=true, cascade={"persist"})
     */
    private $mobileCamps;

    /**
     * @ORM\Column(name="child_to", type="integer", nullable=true)
     */
    private $childTo;

    /**
     * @ORM\Column(name="teenager_from", type="integer", nullable=true)
     */
    private $teenagerFrom;

    /**
     * @ORM\Column(name="teenager_to", type="integer", nullable=true)
     */
    private $teenagerTo;

    /**
     * @ORM\Column(name="adult_from", type="integer", nullable=true)
     */
    private $adultFrom;

    /**
     * @var string $note
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var HotelRoom[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelRoom", mappedBy="hotel", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $rooms;

    /**
     * @var HotelSeason[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelSeason", mappedBy="hotel", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $seasons;

    /**
     * @var HotelSeasonType[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelSeasonType", mappedBy="hotel", cascade={"persist", "remove"})
     */
    private $hotelSeasonTypes;

    /**
     * @var HotelPriceSupplement[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelPriceSupplement", mappedBy="hotel", cascade={"persist", "remove"})
     */
    private $priceSupplements;

    /**
     * @var HotelPriceAdditionalFee[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelPriceAdditionalFee", mappedBy="hotel", cascade={"persist", "remove"})
     */
    private $priceAdditionalFees;

    /**
     * @var HotelPrice[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelPrice", mappedBy="hotel", cascade={"persist", "remove"})
     */
    private $prices;

    /**
     * @var HotelYearsOptions[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelYearsOptions", mappedBy="hotel", cascade={"persist", "remove"})
     */
    private $yearsOptions;

    /**
     * @var boolean $concessionFeesIncl
     * @ORM\Column(name="concession_fees_incl", type="boolean", options={"default": false})
     */
    private $concessionFeesIncl;

    /**
     * @var boolean $wmaIncl
     * @ORM\Column(name="wma_incl", type="boolean", options={"default": false})
     */
    private $wmaIncl;

    /**
     * @var HotelContact[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AltezzaTravelBundle\Entity\HotelContact", mappedBy="hotel", cascade={"persist"}, orphanRemoval=true)
     */
    private $contacts;

    /**
     * @var \DateTime $priceUpTo
     * @ORM\Column(name="price_up_to", type="date", nullable=true)
     */
    private $priceUpTo;

    /**
     * @var array $extraData
     * @ORM\Column(name="extra_data", type="json_array", nullable=true)
     */
    private $extraData;

    /**
     * @var string $status
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;

    /**
     * Hotel constructor.
     */
    public function __construct()
    {
        $this->mobileCamps = new ArrayCollection();
        $this->rooms = new ArrayCollection();
        $this->seasons = new ArrayCollection();
        $this->priceSupplements = new ArrayCollection();
        $this->priceAdditionalFees = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->yearsOptions = new ArrayCollection();
        $this->concessionFeesIncl = false;
        $this->wmaIncl = false;
        $this->status = self::STATUS_DISABLED;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * @param int $ratio
     * @return $this
     */
    public function setRatio(int $ratio)
    {
        $this->ratio = $ratio;

        return $this;
    }

    /**
     * @return TypeHotel
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TypeHotel $type
     * @return $this
     */
    public function setType(TypeHotel $type)
    {
        $this->type = $type;

        return $this;
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
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return HotelChain
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @param HotelChain $chain
     */
    public function setChain($chain)
    {
        $this->chain = $chain;
    }

    /**
     * @return TypeMealPlan[]|ArrayCollection
     */
    public function getMealPlans()
    {
        return $this->mealPlans;
    }

    /**
     * @param TypeMealPlan[]|ArrayCollection $mealPlans
     */
    public function setMealPlans($mealPlans)
    {
        $this->mealPlans = $mealPlans;
    }

    /**
     * @return TerritorialLocation
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param TerritorialLocation $location
     */
    public function setLocation(TerritorialLocation $location)
    {
        $this->location = $location;
    }

    /**
     * @return TerritorialArea|null
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param TerritorialArea|null $area
     */
    public function setArea(TerritorialArea $area = null)
    {
        $this->area = $area;
    }

    /**
     * @return mixed
     */
    public function getAirstrip()
    {
        return $this->airstrip;
    }

    /**
     * @param TerritorialAirstrip|null $airstrip
     * @return $this
     */
    public function setAirstrip(TerritorialAirstrip $airstrip = null)
    {
        $this->airstrip = $airstrip;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTimeToAirstrip()
    {
        return $this->timeToAirstrip;
    }

    /**
     * @param integer $timeToAirstrip
     */
    public function setTimeToAirstrip($timeToAirstrip)
    {
        $this->timeToAirstrip = $timeToAirstrip;
    }

    /**
     * @return boolean
     */
    public function isMobileCamp()
    {
        return $this->isMobileCamp;
    }

    /**
     * @param boolean $isMobileCamp
     */
    public function setIsMobileCamp($isMobileCamp)
    {
        $this->isMobileCamp = $isMobileCamp;
    }

    /**
     * @return HotelMobileCamp[]|ArrayCollection
     */
    public function getMobileCamps()
    {
        return $this->mobileCamps;
    }

    /**
     * @param HotelMobileCamp[]|ArrayCollection $mobileCamps
     */
    public function setMobileCamps($mobileCamps)
    {
        $this->mobileCamps = $mobileCamps;
    }

    /**
     * @param HotelMobileCamp $mobileCamp
     *
     * @return $this
     */
    public function addMobileCamp(HotelMobileCamp $mobileCamp)
    {
        if (!$this->mobileCamps->contains($mobileCamp)) {
            $mobileCamp->setHotel($this);
            $this->mobileCamps->add($mobileCamp);
        }

        return $this;
    }

    /**
     * @param HotelMobileCamp $mobileCamp
     *
     * @return $this
     */
    public function removeMobileCamp(HotelMobileCamp $mobileCamp)
    {
        if ($this->mobileCamps->contains($mobileCamp)) {
            $this->mobileCamps->removeElement($mobileCamp);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearMobileCamps()
    {
        $this->mobileCamps->clear();

        return $this;
    }

    /**
     * @return integer
     */
    public function getAdultFrom()
    {
        return $this->adultFrom;
    }

    /**
     * @param integer $adultFrom
     */
    public function setAdultFrom($adultFrom)
    {
        $this->adultFrom = $adultFrom;
    }

    /**
     * @return integer
     */
    public function getTeenagerFrom()
    {
        return $this->teenagerFrom;
    }

    /**
     * @param integer $teenagerFrom
     */
    public function setTeenagerFrom($teenagerFrom)
    {
        $this->teenagerFrom = $teenagerFrom;
    }

    /**
     * @return integer
     */
    public function getTeenagerTo()
    {
        return $this->teenagerTo;
    }

    /**
     * @param integer $teenagerTo
     */
    public function setTeenagerTo($teenagerTo)
    {
        $this->teenagerTo = $teenagerTo;
    }

    public function isTeenageRangeInit()
    {
        return !(!$this->getTeenagerFrom() && !$this->getTeenagerTo());
    }

    /**
     * @return integer
     */
    public function getChildTo()
    {
        return $this->childTo;
    }

    /**
     * @param integer $childTo
     */
    public function setChildTo($childTo)
    {
        $this->childTo = $childTo;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return HotelRoom[]|ArrayCollection
     */
    public function getRoomsByType(TypeRoom $roomType)
    {
        return $this->rooms->filter(function (HotelRoom $room) use ($roomType) {
            return $roomType === $room->getRoomType();
        });
    }

    /**
     * @return HotelRoom[]|ArrayCollection
     */
    public function getRoomsSpecificType()
    {
        return $this->rooms->filter(function (HotelRoom $room) {
            return $room->getRoomType()->isSpecific();
        });
    }

    /**
     * @return HotelRoom[]|ArrayCollection
     */
    public function getRoomsNotSpecificType()
    {
        return $this->rooms->filter(function (HotelRoom $room) {
            return !$room->getRoomType()->isSpecific();
        });
    }

    /**
     * @return HotelRoom[]|ArrayCollection
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param HotelRoom[]|ArrayCollection $rooms
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
    }

    /**
     * @param bool $excludeSpecific
     * @param bool $addEmpty
     * @param bool $usePlaceholder
     * @return ArrayCollection
     */
    public function getRoomSlugs($excludeSpecific = false, $addEmpty = false, $usePlaceholder = false)
    {
        $slugs = new ArrayCollection();

        foreach ($this->rooms as $room) {
            if ($room->getRoomType()->isSpecific() && $excludeSpecific) {
                continue;
            }

            $slug = [
                'title' => $room->getTitle($usePlaceholder) ? $room->getTitle($usePlaceholder) : 'All',
                'slug' => $room->getSlug($usePlaceholder),
            ];

            if (!$room->getTitle() && !$addEmpty) {
                continue;
            }

            if (!$slugs->contains($slug)) {
                if (!$room->getTitle()) {
                    $slugsArray = $slugs->toArray();
                    array_unshift($slugsArray, $slug);
                    $slugs = new ArrayCollection($slugsArray);

                    continue;
                }

                $slugs->add($slug);
            }
        }

        return $slugs;
    }

    /**
     * @param bool $excludeSpecific
     * @return TypeRoom[]|ArrayCollection
     */
    public function getRoomTypes($excludeSpecific = false)
    {
        $types = new ArrayCollection();

        foreach ($this->rooms as $room) {
            if ($room->getRoomType()->isSpecific() && $excludeSpecific) {
                continue;
            }

            if (!$types->contains($room->getRoomType())) {
                $types->add($room->getRoomType());
            }
        }

        return $types;
    }

    /**
     * @param HotelRoom $room
     *
     * @return $this
     */
    public function addRoom(HotelRoom $room)
    {
        if (!$this->rooms->contains($room)) {
            $room->setHotel($this);
            $this->rooms->add($room);
        }

        return $this;
    }

    /**
     * @param HotelRoom $room
     *
     * @return $this
     */
    public function removeRoom(HotelRoom $room)
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
        }

        return $this;
    }

    /**
     * @var \DateTime $dateFrom
     * @var \DateTime $dateTo
     *
     * @return HotelSeason[]|ArrayCollection
     */
    public function getSeasons(\DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $criteria = Criteria::create();

        if (null !== $dateFrom && null !== $dateTo) {
            $criteria->where(Criteria::expr()->andX(
                Criteria::expr()->lte('dateFrom', $dateTo),
                Criteria::expr()->gte('dateTo', $dateFrom)
            ));
        } elseif (null !== $dateFrom) {
            $criteria->andWhere(new Comparison('dateFrom', Comparison::GTE, $dateFrom));
        } elseif (null !== $dateTo) {
            $criteria->andWhere(new Comparison('dateTo', Comparison::LTE, $dateTo));
        }

        $criteria->orderBy(['dateTo' => Criteria::ASC]);

        return $this->seasons->matching($criteria);
    }

    /**
     * @param HotelSeason[]|ArrayCollection $seasons
     */
    public function setSeasons($seasons)
    {
        $this->seasons = $seasons;
    }

    /**
     * @param HotelSeason $season
     *
     * @return $this
     */
    public function addSeason(HotelSeason $season)
    {
        if (!$this->seasons->contains($season)) {
            $season->setHotel($this);
            $this->seasons->add($season);
        }

        return $this;
    }

    /**
     * @param HotelSeason $season
     *
     * @return $this
     */
    public function removeSeason(HotelSeason $season)
    {
        if ($this->seasons->contains($season)) {
            $season->setHotel(null);
            $this->seasons->removeElement($season);
        }

        return $this;
    }

    /**
     * @var integer $year
     *
     * @return TypeSeason[]|ArrayCollection
     */
    public function getSeasonTypes(int $year)
    {
        $seasonTypes = new ArrayCollection();
        foreach ($this->seasons as $season) {
            if (!$seasonTypes->contains($season->getType()) && $season->getYear() === $year) {
                $seasonTypes->add($season->getType());
            }
        }

        $criteria = Criteria::create();
        $criteria->orderBy(['id' => Criteria::ASC]);
        $hotelSeasonTypes = $this->getHotelSeasonTypes()->matching($criteria);

        $iterator = $seasonTypes->getIterator();
        $iterator->uasort(function ($a, $b) use ($hotelSeasonTypes) {
            $criteria = Criteria::create();
            $criteria->where(new Comparison('seasonType', Comparison::IS, $a));
            $a = $hotelSeasonTypes->matching($criteria)->first();

            $criteria = Criteria::create();
            $criteria->where(new Comparison('seasonType', Comparison::IS, $b));
            $b = $hotelSeasonTypes->matching($criteria)->first();

            if (is_bool($a) || is_bool($b)) {
                return 0;
            }

            /**
             * @var HotelSeasonType $a
             * @var HotelSeasonType $b
             */
            return ($a->getId() < $b->getId()) ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }

    /**
     * @param TypeSeason $seasonType
     * @return bool
     */
    public function haveSeasonType(TypeSeason $seasonType)
    {
        foreach ($this->getHotelSeasonTypes() as $hotelSeasonType) {
            if ($hotelSeasonType->getSeasonType() === $seasonType) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return HotelSeasonType[]|ArrayCollection
     */
    public function getHotelSeasonTypes()
    {
        return $this->hotelSeasonTypes;
    }

    /**
     * @param HotelSeasonType[]|ArrayCollection $hotelSeasonTypes
     * @return $this
     */
    public function setHotelSeasonTypes($hotelSeasonTypes)
    {
        $this->hotelSeasonTypes = $hotelSeasonTypes;

        return $this;
    }

    /**
     * @param HotelSeason $season
     *
     * @return $this
     */
    public function addHotelSeasonType(HotelSeasonType $hotelSeasonType)
    {
        if (!$this->hotelSeasonTypes->contains($hotelSeasonType)) {
            $hotelSeasonType->setHotel($this);
            $this->hotelSeasonTypes->add($hotelSeasonType);
        }

        return $this;
    }

    /**
     * @param HotelSeason $season
     *
     * @return $this
     */
    public function removeHotelSeasonType(HotelSeasonType $hotelSeasonType)
    {
        if ($this->hotelSeasonTypes->contains($hotelSeasonType)) {
            $hotelSeasonType->setHotel(null);
            $this->hotelSeasonTypes->removeElement($hotelSeasonType);
        }

        return $this;
    }

    /**
     * @param bool $addNowYear
     * @param bool $addFeatureYear
     * @return array|ArrayCollection
     */
    public function getYearsList($addNowYear = true, $addFeatureYears = true, $count = 5)
    {
        $yearsList = new ArrayCollection();
        foreach ($this->seasons as $season) {
            if (!$yearsList->contains($season->getYear())) {
                $yearsList->add($season->getYear());
            }
        }

        $nowYear = (int) date('Y');
        if (!$yearsList->contains($nowYear) && $addNowYear) {
            $yearsList->add($nowYear);
        }

        if ($addFeatureYears) {
            for ($i = 1; $i <= $count; $i++) {
                $featureYear = (int) (date('Y') + $i);
                if (!$yearsList->contains($featureYear) && $addFeatureYears) {
                    $yearsList->add($featureYear);
                }
            }
        }

        $yearsList = $yearsList->toArray();
        sort($yearsList);
        return $yearsList;
    }

    /**
     * @param int $year
     * @return bool
     */
    public function hasYear(int $year)
    {
        $yearsList = $this->getYearsList(false, false);

        return \in_array($year, $yearsList);
    }

    /**
     * @return HotelPriceSupplement[]|ArrayCollection
     */
    public function getPriceSupplements()
    {
        $criteria = Criteria::create()
            ->orderBy(['dateFrom' => Criteria::ASC]);

        return $this->priceSupplements->matching($criteria);
    }

    /**
     * @param HotelPriceSupplement[]|ArrayCollection $priceSupplements
     */
    public function setPriceSupplements($priceSupplements)
    {
        $this->priceSupplements = $priceSupplements;
    }

    /**
     * @param HotelPriceSupplement $priceSupplements
     *
     * @return $this
     */
    public function addPriceSupplement(HotelPriceSupplement $priceSupplements)
    {
        if (!$this->priceSupplements->contains($priceSupplements)) {
            $priceSupplements->setHotel($this);
            $this->priceSupplements->add($priceSupplements);
        }

        return $this;
    }

    /**
     * @param HotelPriceSupplement $priceSupplements
     *
     * @return $this
     */
    public function removePriceSupplement(HotelPriceSupplement $priceSupplements)
    {
        if ($this->priceSupplements->contains($priceSupplements)) {
            $this->priceSupplements->removeElement($priceSupplements);
        }

        return $this;
    }

    /**
     * @return HotelPriceAdditionalFee[]|ArrayCollection
     */
    public function getPriceAdditionalFees()
    {
        $criteria = Criteria::create()
            ->orderBy(['year' => Criteria::ASC]);

        return $this->priceAdditionalFees->matching($criteria);
    }

    /**
     * @param HotelPriceAdditionalFee[]|ArrayCollection $priceAdditionalFees
     */
    public function setPriceAdditionalFees($priceAdditionalFees)
    {
        $this->priceAdditionalFees = $priceAdditionalFees;
    }

    /**
     * @param HotelPriceAdditionalFee $priceAdditionalFees
     *
     * @return $this
     */
    public function addPriceAdditionalFee(HotelPriceAdditionalFee $priceAdditionalFees)
    {
        if (!$this->priceAdditionalFees->contains($priceAdditionalFees)) {
            $priceAdditionalFees->setHotel($this);
            $this->priceAdditionalFees->add($priceAdditionalFees);
        }

        return $this;
    }

    /**
     * @param HotelPriceAdditionalFee $priceAdditionalFees
     *
     * @return $this
     */
    public function removePriceAdditionalFee(HotelPriceAdditionalFee $priceAdditionalFees)
    {
        if ($this->priceAdditionalFees->contains($priceAdditionalFees)) {
            $this->priceAdditionalFees->removeElement($priceAdditionalFees);
        }

        return $this;
    }

    /**
     * @param int|null $year
     * @return HotelPrice[]|ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getPrices(int $year = null)
    {
        if (!$year) {
            return $this->prices;
        }

        $criteria = Criteria::create();
        $criteria->where(new Comparison('year', Comparison::EQ, $year));

        return $this->prices->matching($criteria);
    }

    /**
     * @param HotelPrice[]|ArrayCollection $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @param HotelPrice $hotelPrice
     * @return $this
     */
    public function addPrice(HotelPrice $hotelPrice)
    {
        if (!$this->prices->contains($hotelPrice)) {
            $hotelPrice->setHotel($this);
            $this->prices->add($hotelPrice);
        }

        return $this;
    }

    /**
     * @param HotelPrice $hotelPrice
     * @return $this
     */
    public function removePrice(HotelPrice $hotelPrice)
    {
        if ($this->prices->contains($hotelPrice)) {
            $this->prices->removeElement($hotelPrice);
        }

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateLastPrice()
    {
        $dateLastPrice = null;

        $years = $this->getYearsList(false, false);
        foreach ($years as $year) {
            $dateLastPriceByYear = null;
            $dateFrom = new \DateTime('first day of January ' . $year);
            $dateTo = new \DateTime('last day of December ' . $year);

            $seasons = $this->getSeasons($dateFrom, $dateTo);
            /** @var HotelSeason $season */
            foreach ($seasons as $season) {
                foreach ($season->getType()->getPrices() as $hotelPrice) {
                    if ($hotelPrice->getPrice() && $hotelPrice->getPrice() > 0) {
                        $dateLastPriceByYear = $season->getDateTo();
                    }
                }
            }

            if (!$dateLastPriceByYear) {
                return $dateLastPrice;
            }

            $dateLastPrice = $dateLastPriceByYear;
        }

        return $dateLastPrice;
    }

    /**
     * @return HotelYearsOptions[]|ArrayCollection
     */
    public function getYearsOptions()
    {
        return $this->yearsOptions;
    }

    /**
     * @param HotelYearsOptions[]|ArrayCollection $yearsOptions
     * @return $this
     */
    public function setYearsOptions($yearsOptions)
    {
        $this->yearsOptions = $yearsOptions;

        return $this;
    }

    /**
     * @param $year
     * @param $option
     * @param $type
     * @param $value
     * @return $this
     */
    public function setYearOption($year, $option, $type, $value)
    {
        foreach ($this->getYearsOptions() as $yearsOption) {
            if ($yearsOption->getYear() === $year && $yearsOption->getSlug() === $option) {
                $yearsOption->setValue($value, $type);

                return $this;
            }
        }

        $yearsOption = (new HotelYearsOptions())
            ->setHotel($this)
            ->setYear($year)
            ->setSlug($option)
            ->setValue($value, $type)
        ;

        $this->yearsOptions->add($yearsOption);

        return $this;
    }

    /**
     * @param int    $year
     * @param string $option
     * @param mixed  $default
     * @return mixed
     */
    public function getYearOption(int $year, string $option, $default = false)
    {
        foreach ($this->getYearsOptions() as $yearsOption) {
            if ($yearsOption->getYear() === $year
                && $yearsOption->getSlug() === $option
            ) {
                return $yearsOption->getValue();
            }
        }

        return $default;
    }

    /**
     * @return bool
     */
    public function isConcessionFeesIncl(): bool
    {
        return $this->concessionFeesIncl;
    }

    /**
     * @param bool $concessionFeesIncl
     * @return $this
     */
    public function setConcessionFeesIncl(bool $concessionFeesIncl)
    {
        $this->concessionFeesIncl = $concessionFeesIncl;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWmaIncl(): bool
    {
        return $this->wmaIncl;
    }

    /**
     * @param bool $wmaIncl
     * @return $this
     */
    public function setWmaIncl(bool $wmaIncl)
    {
        $this->wmaIncl = $wmaIncl;

        return $this;
    }

    /**
     * @return HotelContact[]|ArrayCollection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param HotelContact[]|ArrayCollection $contacts
     * @return $this
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @param HotelContact $contact
     * @return $this
     */
    public function addContact(HotelContact $contact)
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setHotel($this);
        }

        return $this;
    }

    public function removeContact(HotelContact $contact)
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPriceUpTo()
    {
        return $this->priceUpTo;
    }

    /**
     * @param \DateTime $priceUpTo
     * @return $this
     */
    public function setPriceUpTo($priceUpTo)
    {
        $this->priceUpTo = $priceUpTo;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMonthCountFromNow()
    {
        if (!$this->getPriceUpTo()) {
            return null;
        }

        $now = new \DateTime('now');
        $diff = $now->diff($this->getPriceUpTo());

        return $diff->format('%y') * 12 + $diff->format('%m');
    }

    /**
     * @param array ...$args
     * @return array|mixed|null
     */
    public function getExtraData(...$args)
    {
        if (!$args) {
            return $this->extraData;
        }

        $data = $this->extraData;
        foreach ($args as $arg) {
            if (!isset($data[$arg])) {
                return null;
            }

            $data = $data[$arg];
        }

        return $data;
    }

    /**
     * @param array $extraData
     * @return $this
     */
    public function setExtraData(array $extraData = null)
    {
        $this->extraData = $extraData;

        return $this;
    }

    /**
     * @param string $name
     * @param array  $data
     * @return $this
     */
    public function addExtraData(string $name, array $data)
    {
        $this->extraData[$name] = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}

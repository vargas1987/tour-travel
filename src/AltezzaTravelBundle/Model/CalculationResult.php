<?php

namespace AltezzaTravelBundle\Model;

use AltezzaTravelBundle\Doctrine\Common\Collections\ExtensionArrayCollection;
use AltezzaTravelBundle\Entity\AbstractCalculationPerson;

class CalculationResult
{
    const BLOCK_TRANSFERS = 'transfers';

    const BLOCK_PARK_FEES = 'park_fees';

    const BLOCK_ACCOMMODATION = 'accommodation';

    const BLOCK_FLIGHT_TICKETS = 'flight_tickets';

    const BLOCK_OTHER = 'other';

    const BLOCK_OUR_COMMISSION = 'our_commission';

    const STATUS_SUCCESS = 'success';

    const STATUS_WARNING = 'warning';

    const STATUS_DANGER = 'danger';

    /**
     * @var string
     */
    private $block;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer|null
     */
    private $pax;

    /**
     * @var CalculationResultPricePerPerson[]|ExtensionArrayCollection
     */
    private $pricePerPersons;

    /**
     * @var float|null
     */
    private $price;

    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $status;

    /**
     * @var array
     */
    private $options;

    public function __construct()
    {
        $this->pax = null;
        $this->group = null;
        $this->pricePerPersons = new ExtensionArrayCollection();
        $this->options = [];
    }

    /**
     * @return string
     */
    public function getBlock(): string
    {
        return $this->block;
    }

    /**
     * @param string $block
     * @return $this
     */
    public function setBlock(string $block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPax()
    {
        return $this->pax;
    }

    /**
     * @param int $pax
     * @return $this
     */
    public function setPax(int $pax)
    {
        $this->pax = $pax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceAdult()
    {
        $price = $this->getPricePerPersons(AbstractCalculationPerson::TYPE_ADULT)->reduce(
            function ($result, CalculationResultPricePerPerson $pricePerPerson) {
                $result += $pricePerPerson->getTotalPrice();

                return $result;
            },
            0
        );

        return $price;
    }

    /**
     * @return float|null
     */
    public function getPriceChild()
    {
        $price = $this->getPricePerPersons(AbstractCalculationPerson::TYPE_CHILD)->reduce(
            function ($result, CalculationResultPricePerPerson $pricePerPerson) {
                $result += $pricePerPerson->getTotalPrice();

                return $result;
            },
            0
        );

        return $price;
    }

    /**
     * @param AbstractCalculationPerson $person
     * @return CalculationResultPricePerPerson
     */
    public function getPriceByPerson(AbstractCalculationPerson $person)
    {
        return $this->pricePerPersons->filter(function (CalculationResultPricePerPerson $pricePerPerson) use ($person) {
            return $pricePerPerson->getPerson() === $person;
        })->first();
    }

    /**
     * @param string $type
     * @return ExtensionArrayCollection|CalculationResultPricePerPerson[]
     */
    public function getPricePerPersons(string $type = null)
    {
        if (!$type) {
            return $this->pricePerPersons;
        }

        return $this->pricePerPersons->filter(function (CalculationResultPricePerPerson $pricePerPerson) use ($type) {
            return $pricePerPerson->getType() === $type;
        });
    }

    /**
     * @param ExtensionArrayCollection|CalculationResultPricePerPerson[] $pricePerPersons
     * @return $this
     */
    public function setPricePerPersons($pricePerPersons)
    {
        $this->pricePerPersons = $pricePerPersons;

        return $this;
    }

    /**
     * @param CalculationResultPricePerPerson $pricePerPerson
     * @return $this
     */
    public function addPricePerPerson(CalculationResultPricePerPerson $pricePerPerson)
    {
        $this->pricePerPersons->add($pricePerPerson);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price ?? 0;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        $price = $this->getPricePerPersons()->reduce(
                function ($result, CalculationResultPricePerPerson $pricePerPerson) {
                    $result += $pricePerPerson->getTotalPrice();

                    return $result;
                },
                0
            ) + $this->getPrice();

        return $price;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
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

    /**
     * @param mixed $options
     * @return $this
     */
    public function setOptions(array $options = null)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @return $this
     */
    public function addOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * @param array ...$fields
     * @return null
     */
    public function getOption(...$fields)
    {
        return $this->getRecursiveOption($this->options, $fields);
    }

    /**
     * @param string $name
     */
    public function removeOption(string $name)
    {
        if (isset($this->options[$name])) {
            unset($this->options[$name]);
        }
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @param array ...$fields
     * @return array
     */
    protected function getRecursiveOption($options, $fields)
    {
        if (empty($fields)) {
            return $options;
        }
        $field = array_shift($fields);

        return $this->getRecursiveOption($options[$field] ?? null, $fields);
    }
}
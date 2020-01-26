<?php

namespace AltezzaTravelBundle\Doctrine\Common\Collections;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ExtensionArrayCollection
 * @package AltezzaTravelBundle\Doctrine\Common\Collections
 *
 * {@inheritDoc}
 */
class ExtensionArrayCollection extends ArrayCollection
{
    /**
     * Reduce the collection into a single value.
     *
     * @param \Closure $func
     * @param null $initialValue
     * @return mixed
     */
    public function reduce(\Closure $func, $initialValue = null)
    {
        return array_reduce($this->toArray(), $func, $initialValue);
    }
}
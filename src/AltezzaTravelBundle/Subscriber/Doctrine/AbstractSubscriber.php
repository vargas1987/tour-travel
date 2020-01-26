<?php

namespace AltezzaTravelBundle\Subscriber\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class AbstractSubscriber
 * @package AltezzaTravelBundle\Subscriber\Doctrine
 */
abstract class AbstractSubscriber implements EventSubscriber
{
    /**
     * @param PreUpdateEventArgs $args
     * @param string             $value
     * @return bool
     */
    protected function isInit(PreUpdateEventArgs $args, $value)
    {
        return $args->hasChangedField($value) && $args->getOldValue($value) === null && $args->getNewValue($value) !== null;
    }

    /**
     * @param PreUpdateEventArgs $args
     * @param string             $value
     * @return bool
     */
    protected function isChange(PreUpdateEventArgs $args, $value)
    {
        return $args->hasChangedField($value) && $args->getOldValue($value) !== null && $args->getNewValue($value) !== null;
    }

    /**
     * @param PreUpdateEventArgs $args
     * @param string             $value
     * @return bool
     */
    protected function isReset(PreUpdateEventArgs $args, $value)
    {
        return $args->hasChangedField($value) && $args->getOldValue($value) !== null && $args->getNewValue($value) === null;
    }

    /**
     * @param PreUpdateEventArgs $args
     * @param array              $values
     * @return bool
     */
    protected function checkManyValues(PreUpdateEventArgs $args, array $values)
    {
        return !empty(array_intersect(array_keys($args->getEntityChangeSet()), $values));
    }

    /**
     * @param PreUpdateEventArgs $args
     * @param string             $value
     * @param string             $type
     * @return bool
     */
    protected function isEqual(PreUpdateEventArgs $args, string $value, string $type)
    {
        if (!$args->hasChangedField($value)) {
            return false;
        }

        switch ($type) {
            case 'int':
                return (int) $args->getOldValue($value) === (int) $args->getNewValue($value);
            case 'float':
                return (float) $args->getOldValue($value) === (float) $args->getNewValue($value);
            case 'string':
                return (string) $args->getOldValue($value) === (string) $args->getNewValue($value);
        }

        return $args->getOldValue($value) === $args->getNewValue($value);
    }
}

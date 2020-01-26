<?php

namespace AltezzaTravelBundle\Command;

use Doctrine\ORM\EntityManager;
use Gedmo\Timestampable\TimestampableListener;

/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/issues/1722
 * @see https://stackoverflow.com/questions/29533795/disable-doctrine-timestampable-auto-updating-the-updatedat-field-on-certain-up/53666915#53666915
 * Trait DisableTimestampableTrait
 * @package AltezzaTravelBundle\Command
 */
trait DisableTimestampableTrait
{
    /**
     * @param EntityManager $em
     */
    private function disableTimestampable(EntityManager $em)
    {
        $eventManager = $em->getEventManager();
        foreach ($eventManager->getListeners('onFlush') as $listener) {
            if ($listener instanceof TimestampableListener) {
                $eventManager->removeEventSubscriber($listener);
            }
        }
    }
}
<?php

namespace AltezzaTravelBundle\Configuration\Tour;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class RoomConfiguration
 * @package AltezzaTravelBundle\Configuration\Tour
 */
class RoomConfiguration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rooms');

        $rootNode
            ->children()
                ->scalarNode('roomType')
                ->end()
                ->node('accommodations', RoomAccommodationConfiguration::class)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

}
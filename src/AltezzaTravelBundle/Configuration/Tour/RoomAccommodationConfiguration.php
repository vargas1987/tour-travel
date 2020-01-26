<?php

namespace AltezzaTravelBundle\Configuration\Tour;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class RoomAccommodationConfiguration
 * @package AltezzaTravelBundle\Configuration\Tour
 */
class RoomAccommodationConfiguration implements ConfigurationInterface
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
            ->end()
        ;

        return $treeBuilder;
    }

}
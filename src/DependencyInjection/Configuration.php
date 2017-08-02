<?php

namespace Urbanara\OrderSplitterPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('order_splitter');

        $rootNode
            ->children()
                ->arrayNode('split_by_total')
                    ->useAttributeAsKey('country')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('value')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

}

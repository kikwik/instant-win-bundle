<?php

namespace Kikwik\InstantWinBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('kikwik_instantwin');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('configuration_repository')->defaultValue('App\Repository\ConfigurationRepository')->end()
                ->scalarNode('lead_repository')->defaultValue('App\Repository\LeadRepository')->end()
            ->end()
        ;

        return $treeBuilder;
    }

}
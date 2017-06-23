<?php

namespace Ruwork\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        /** @noinspection PhpUndefinedMethodInspection */
        $treeBuilder->root('ruwork_core')
            ->children()
                ->arrayNode('mailer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('from')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('email')->isRequired()->cannotBeEmpty()->end()
                                    ->arrayNode('name')
                                        ->isRequired()
                                        ->prototype('scalar')->cannotBeEmpty()->end()
                                        ->beforeNormalization()->castToArray()->end()
                                    ->end()
                                    ->scalarNode('locale')->isRequired()->cannotBeEmpty()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('security')
                    ->addDefaultsIfNotSet()
                        ->children()
                        ->scalarNode('default_remember_me_services')
                            ->cannotBeEmpty()
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

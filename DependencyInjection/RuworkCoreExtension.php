<?php

namespace Ruwork\CoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class RuworkCoreExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->findDefinition('ruwork.mailer.message_factory')
            ->replaceArgument(2, $mergedConfig['mailer']['translation_domain']);

        if (null !== $drms = $mergedConfig['security']['default_remember_me_services']) {
            $container->findDefinition('ruwork.security.auth_helper')
                ->replaceArgument(4, new Reference($drms));
        }
    }
}

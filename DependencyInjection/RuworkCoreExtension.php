<?php

namespace Ruwork\CoreBundle\DependencyInjection;

use Ruwork\CoreBundle\Mailer\Mailer;
use Ruwork\CoreBundle\Security\AuthenticationHelper;
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
        (new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config')))
            ->load('services.yml');

        $container->findDefinition(Mailer::class)->setArgument(3, $mergedConfig['mailer']['from']);

        if (null !== $drms = $mergedConfig['security']['default_remember_me_services']) {
            $container->findDefinition(AuthenticationHelper::class)->setArgument(4, new Reference($drms));
        }
    }
}

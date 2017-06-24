<?php

namespace Ruwork\CoreBundle\DependencyInjection;

use Ruwork\CoreBundle\EventListener\I18nControllerTemplateListener;
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
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->findDefinition(Mailer::class)->setArgument(2, $mergedConfig['mailer']['from']);

        if (null !== $drms = $mergedConfig['security']['default_remember_me_services']) {
            $container->findDefinition(AuthenticationHelper::class)->setArgument(4, new Reference($drms));
        }

        if ($mergedConfig['i18n']['enabled']) {
            if ($mergedConfig['i18n']['suffix_controller_templates']) {
                $container->autowire(I18nControllerTemplateListener::class)
                    ->setAutoconfigured(true)
                    ->setPublic(false)
                    ->setArgument('$locales', $mergedConfig['i18n']['locales'])
                    ->setArgument('$defaultLocale', $mergedConfig['i18n']['default_locale']);
            }
        }
    }
}

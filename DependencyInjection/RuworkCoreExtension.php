<?php

namespace Ruwork\CoreBundle\DependencyInjection;

use Ruwork\CoreBundle\Asset\VersionStrategy\FilemtimeStrategy;
use Ruwork\CoreBundle\EventListener\I18nControllerTemplateListener;
use Ruwork\CoreBundle\Mailer\Mailer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class RuworkCoreExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    public function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($config['assets']['enabled']) {
            $container->register(FilemtimeStrategy::class)
                ->setArgument('$webDir', $config['assets']['web_dir']);
        }

        if ($config['i18n']['enabled']) {
            if ($config['i18n']['suffix_controller_templates']) {
                $container->autowire(I18nControllerTemplateListener::class)
                    ->setAutoconfigured(true)
                    ->setPublic(false)
                    ->setArgument('$locales', $config['i18n']['locales'])
                    ->setArgument('$defaultLocale', $config['i18n']['default_locale']);
            }
        }

        $container->findDefinition(Mailer::class)->setArgument(2, $config['mailer']['from']);
    }
}

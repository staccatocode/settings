<?php

/*
 * This file is part of settings component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Bundle\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class StaccatoSettingsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // Set setting model
        $container->setParameter('staccato_settings.model.setting.class', $config['setting_class']);

        // Set services
        $container->setAlias('staccato_settings.settings_storage', $config['service']['settings_storage']);
        $container->setAlias('staccato_settings.settings_manager', $config['service']['settings_manager']);
        $container->setAlias('st.settings', 'staccato_settings.settings_manager');

        $settingsStorageDefinition = $container->findDefinition('staccato_settings.settings_storage');

        // Enable doctrine mapping if provided doctrine settings storage
        if ($settingsStorageDefinition->hasTag('staccato.mapping.doctrine')) {
            $container->setParameter('staccato_settings.doctrine_mapping', true);
        }
    }
}

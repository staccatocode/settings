<?php

/*
 * This file is part of settings component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Component\Settings\Model;

use Symfony\Component\HttpFoundation\ParameterBag;

abstract class SettingsManager implements SettingsManagerInterface
{
    /**
     * @var ParameterBag
     */
    protected $settings;

    /**
     * @var SettingsStorageInterface
     */
    protected $settingsStorage;

    /**
     * Constructor.
     */
    public function __construct(SettingsStorageInterface $storage)
    {
        $this->settingsStorage = $storage;
        $this->reload();
    }

    /**
     * {inheritdoc}.
     */
    public function get($key, $defaultValue = null)
    {
        return $this->settings->get($key, $defaultValue);
    }

    /**
     * {inheritdoc}.
     */
    public function set($key, $value = null)
    {
        $this->settings->set($key, $value);

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function remove($key)
    {
        $this->settings->remove($key);

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function reload()
    {
        if (!$this->settingsStorage instanceof SettingsStorageInterface) {
            throw new \RuntimeException('Could not store settings, because no settings stroage was set.');
        }

        $this->settings = new ParameterBag($this->settingsStorage->load());

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function save()
    {
        if (!$this->settingsStorage instanceof SettingsStorageInterface) {
            throw new \RuntimeException('Could not store settings, because no settings stroage was set.');
        }

        return $this->settingsStorage->store($this->settings->all());
    }
}

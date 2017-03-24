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

interface SettingsManagerInterface
{
    /**
     * Get setting value by key.
     * If setting not found return default value.
     *
     * @param string $key
     * @param mixed  $defaultValue
     *
     * return mixed
     */
    public function get($key, $defaultValue = null);

    /**
     * Set setting value by key.
     *
     * @param string $key
     * @param mixed  $defaultValue
     *
     * return mixed
     */
    public function set($key, $value = null);

    /**
     * Remove setting by key.
     *
     * @param string $key
     *
     * return self
     */
    public function remove($key);

    /**
     * Persist settings.
     */
    public function save();
}

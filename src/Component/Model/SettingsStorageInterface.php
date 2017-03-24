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

interface SettingsStorageInterface
{
    /**
     * Load settings from storage
     * and return as array.
     *
     * @return array
     */
    public function load(): array;

    /**
     * Store settings from array.
     *
     * @param array $settings
     *
     * @return bool
     */
    public function store(array $settings): bool;
}

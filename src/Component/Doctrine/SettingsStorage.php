<?php

/*
 * This file is part of settings component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Component\Settings\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Staccato\Component\Settings\Model\SettingsStorageInterface;

class SettingsStorage implements SettingsStorageInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param ObjectManager $om
     * @param string        $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * {@iheritdoc}.
     */
    public function load(): array
    {
        $result = array();

        foreach ($this->repository->findAll() as $s) {
            $result[$s->getKey()] = $s->getValue();
        }

        return $result;
    }

    /**
     * {@iheritdoc}.
     */
    public function store(array $settings): bool
    {
        $objects = $this->repository->findAll();

        // Edit or remove setting
        foreach ($objects as $o) {
            $key = $o->getKey();

            if (isset($settings[$key])) {
                if ($o->getValue() !== $settings[$key]) {
                    $o->setValue($settings[$key]);

                    $this->objectManager->persist($o);
                }
            } else {
                $this->objectManager->remove($o);
            }

            unset($settings[$key]);
        }

        // Add new setting
        foreach ($settings as $key => $value) {
            $o = new $this->class();
            $o->setKey($key);
            $o->setValue($value);

            $this->objectManager->persist($o);
        }

        $this->objectManager->flush();

        return true;
    }
}

<?php

namespace cubes\system\storage;

class Storage
{
    /**
     * @var StorageService
     */
    protected $service;

    /**
     * @param StorageService $service
     */
    public function __construct(StorageService $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $key
     * @param null $default
     * @param bool $safe allow classes deserialization if false
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null, bool $safe = true)
    {
        $condition = $this->service->createCondition(['key' => $key]);
        /** @var StorageItem $item */
        if ($item = $this->service->findOne($condition)) {
            return \unserialize($item->value, ['allowed_classes' => !$safe]);
        }
        return $default;
    }

    /**
     * @param string $key
     * @param mixed $object
     */
    public function set(string $key, $object)
    {
        $condition = $this->service->createCondition(['key' => $key]);
        /** @var StorageItem $item */
        if (!$item = $this->service->findOne($condition)) {
            $item = $this->service->create();
            $item->key = $key;
        }
        $item->value = \serialize($object);
        $this->service->save($item);
    }
}

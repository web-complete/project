<?php

namespace WebComplete\microDb;

class Factory
{

    /**
     * @param string $file
     * @param string $type
     *
     * @return StorageInterface
     */
    public function storage(string $file, string $type): StorageInterface
    {
        switch ($type) {
            case 'memory':
                $result = new StorageMemory($file);
                break;
            case 'file':
            default:
                $result = new StorageFile($file);
                break;
        }

        return $result;
    }

    /**
     * @param StorageInterface $storage
     *
     * @return Collection
     */
    public function collection(StorageInterface $storage): Collection
    {
        return new Collection($storage);
    }
}

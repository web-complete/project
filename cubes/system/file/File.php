<?php

namespace cubes\system\file;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
 * @property string $code
 * @property string $file_name
 * @property string $mime_type
 * @property string $base_dir
 * @property string $url
 * @property int $sort
 * @property array $data
 */
class File extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'code' => Cast::STRING,
            'file_name' => Cast::STRING,
            'mime_type' => Cast::STRING,
            'base_dir' => Cast::STRING,
            'url' => Cast::STRING,
            'sort' => Cast::INT,
            'data' => Cast::ARRAY,
        ];
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->base_dir . $this->url;
    }

    /**
     * @return string
     */
    public function getCacheDirUrl(): string
    {
        $filePath = $this->url;
        $filePathInfo = \pathinfo($filePath);
        $dirName = $filePathInfo['dirname'] ?? '';
        $fileName = $filePathInfo['filename'] ?? '';
        return $dirName . '/' . $fileName . '.cache';
    }

    /**
     * @param bool $createIfNotExists
     *
     * @return string
     * @throws \RuntimeException
     */
    public function getCacheDir(bool $createIfNotExists = false): string
    {
        $result = $this->base_dir . $this->getCacheDirUrl();
        if ($createIfNotExists && !\file_exists($result) && !\mkdir($result) && !\is_dir($result)) {
            throw new \RuntimeException(\sprintf('Directory "%s" was not created', $result));
        }
        return $result;
    }
}

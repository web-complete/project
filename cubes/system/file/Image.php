<?php

namespace cubes\system\file;

use Intervention\Image\ImageManagerStatic;

class Image
{
    const MEMORY_LIMIT = '500M';

    /**
     * @var File
     */
    protected $file;
    protected $width;
    protected $height;

    /**
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * @param int|null $width
     * @param int|null $height
     *
     * @return $this
     */
    public function size(int $width = null, int $height = null)
    {
        $this->width = $width ?: null;
        $this->height = $height ?: null;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->file->url;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getResizedUrl(): string
    {
        if ($this->width && $this->file->getCacheDir(true)) {
            $fileCacheDirUrl = $this->file->getCacheDirUrl();
            $resizedFileName = (int)$this->width . '_' . (int)$this->height . '_' . $this->file->file_name;
            $resizedFileUrl = $fileCacheDirUrl . '/' . $resizedFileName;
            $resizedFilePath = $this->file->base_dir . $resizedFileUrl;

            if (!\file_exists($resizedFilePath)) {
                $this->createResizedImage(
                    $this->file->getFilePath(),
                    $resizedFilePath,
                    $this->width,
                    $this->height
                );
            }

            return $resizedFileUrl;
        }

        return $this->getUrl();
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->file->file_name;
    }

    /**
     * @return array
     */
    public function getFileData(): array
    {
        return $this->file->data;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param array $cropData
     */
    public function crop(array $cropData)
    {
        $x = $cropData['x'] ?? null;
        $y = $cropData['y'] ?? null;
        $width = $cropData['width'] ?? null;
        $height = $cropData['height'] ?? null;
        if ($x !== null && $y !== null && $width && $height) {
            $filePath = $this->file->getFilePath();
            $this->createCroppedImage(
                $filePath,
                $filePath,
                (int)$x,
                (int)$y,
                (int)$width,
                (int)$height
            );
        }
    }

    /**
     * @param string $srcFile
     * @param string $destFile
     * @param int $width
     * @param int $height
     */
    protected function createResizedImage(string $srcFile, string $destFile, int $width, int $height = null)
    {
        \ini_set('memory_limit', self::MEMORY_LIMIT);
        $height
            ? ImageManagerStatic::make($srcFile)->fit($width, $height)->save($destFile)
            : ImageManagerStatic::make($srcFile)->widen($width)->save($destFile);
    }

    /**
     * @param string $srcFile
     * @param string $destFile
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     */
    protected function createCroppedImage(string $srcFile, string $destFile, int $x, int $y, int $width, int $height)
    {
        \ini_set('memory_limit', self::MEMORY_LIMIT);
        ImageManagerStatic::make($srcFile)->crop($width, $height, $x, $y)->save($destFile);
    }
}

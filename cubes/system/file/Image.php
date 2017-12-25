<?php

namespace cubes\system\file;

use Intervention\Image\ImageManagerStatic;

class Image
{

    /**
     * @var File
     */
    protected $file;
    protected $width;
    protected $height;
    protected $baseDir;

    /**
     * @param File $file
     * @param string $baseDir
     */
    public function __construct(File $file, string $baseDir)
    {
        $this->file = $file;
        $this->baseDir = $baseDir;
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return $this
     */
    public function size(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->width && $this->height) {
            $fileName = $this->width . '_' . $this->height . '_' . $this->file->file_name;
            $fileUrl = $this->file->path . '/' . $fileName;
            if (!\file_exists($this->baseDir . $fileUrl)) {
                $this->createResizedImage(
                    $this->baseDir . $this->file->url,
                    $this->baseDir . $fileUrl,
                    $this->width,
                    $this->height
                );
            }
            return $fileUrl;
        }
        return $this->file->url;
    }

    /**
     * @return string
     */
    public function getUrlPath(): string
    {
        return $this->file->path;
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
     * @param string $srcFile
     * @param string $destFile
     * @param int $width
     * @param int $height
     */
    protected function createResizedImage(string $srcFile, string $destFile, int $width, int $height)
    {
        ImageManagerStatic::make($srcFile)->fit($width, $height)->save($destFile);
    }
}

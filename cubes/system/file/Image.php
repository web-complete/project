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
     * @param string $srcFile
     * @param string $destFile
     * @param int $width
     * @param int $height
     */
    protected function createResizedImage(string $srcFile, string $destFile, int $width, int $height = null)
    {
        $height
            ? ImageManagerStatic::make($srcFile)->fit($width, $height)->save($destFile)
            : ImageManagerStatic::make($srcFile)->widen($width)->save($destFile);
    }
}

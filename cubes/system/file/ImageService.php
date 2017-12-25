<?php

namespace cubes\system\file;

class ImageService
{

    /**
     * @var FileService
     */
    protected $fileService;
    /**
     * @var ImageFactory
     */
    protected $factory;

    /**
     * @param FileService $fileService
     * @param ImageFactory $factory
     */
    public function __construct(FileService $fileService, ImageFactory $factory)
    {
        $this->fileService = $fileService;
        $this->factory = $factory;
    }

    /**
     * @param int|string $imageId
     *
     * @return Image|null
     */
    public function findById($imageId)
    {
        /** @var File $file */
        if ($file = $this->fileService->findById($imageId)) {
            return $this->factory->create($file, $this->fileService->getBaseDir());
        }
        return null;
    }
}

<?php

namespace cubes\system\file;

use WebComplete\core\entity\AbstractEntityService;

class FileService extends AbstractEntityService implements FileRepositoryInterface
{

    /**
     * @var FileRepositoryInterface
     */
    protected $repository;

    /**
     * @param FileRepositoryInterface $repository
     */
    public function __construct(FileRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param string $path
     * @param string $code
     * @param string|null $fileName
     * @param string|null $mimeType
     * @param int $sort
     * @param array $data
     *
     * @return File
     */
    public function addFromPath(
        string $path,
        string $code,
        string $fileName = null,
        string $mimeType = null,
        int $sort = 100,
        array $data = []
    ): File {
        if (!$fileName) { // TODO wrong
            $fileName = \md5(\microtime() . \random_int(1, 100000));
        }
        // TODO all
        /** @var File $item */
        $item = $this->create();
        $item->code = $code;
        $item->file_name = $fileName;
        $item->mime_type = $mimeType;
        $item->sort = $sort;
        $item->data = $data;
        $this->save($item);
        return $item;
    }

    public function addFromData()
    {
        // TODO all
    }
}

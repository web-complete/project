<?php

namespace cubes\system\file;

use cubes\system\file\repository\FileRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\alias\AliasService;

class FileService extends AbstractEntityService implements FileRepositoryInterface
{

    protected $baseDir = '@web';
    protected $baseUrl = '/usr';
    protected $mode = 0755;

    /**
     * @var FileRepositoryInterface
     */
    protected $repository;
    /**
     * @var AliasService
     */
    protected $aliasService;
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param FileRepositoryInterface $repository
     * @param AliasService $aliasService
     * @param Filesystem $filesystem
     *
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    public function __construct(
        FileRepositoryInterface $repository,
        AliasService $aliasService,
        Filesystem $filesystem
    ) {
        parent::__construct($repository);
        $this->aliasService = $aliasService;
        $this->filesystem = $filesystem;
        $this->baseDir = \rtrim($this->aliasService->get($this->baseDir), '/');
    }

    /**
     * @param string $content
     * @param string|null $newFileName
     * @param string|null $mimeType
     * @param string|null $code
     * @param int $sort
     * @param array $data
     * @param bool $parseBase64
     *
     * @return File
     * @throws \Exception
     */
    public function createFileFromContent(
        string $content,
        string $newFileName,
        string $mimeType = null,
        string $code = null,
        int $sort = 100,
        array $data = [],
        bool $parseBase64 = true
    ): File {
        $content = $parseBase64 ? $this->parseBase64Data($content) : $content;
        $tmpFile = \tempnam(\sys_get_temp_dir(), 'file');
        \file_put_contents($tmpFile, $content);
        return $this->createFileFromPath($tmpFile, $newFileName, $mimeType, $code, $sort, $data);
    }

    /**
     * @param string $pathOrUrl
     * @param string|null $newFileName
     * @param string|null $mimeType
     * @param string|null $code
     * @param int $sort
     * @param array $data
     *
     * @return File
     * @throws \Exception
     */
    public function createFileFromPath(
        string $pathOrUrl,
        string $newFileName = null,
        string $mimeType = null,
        string $code = null,
        int $sort = 100,
        array $data = []
    ): File {
        $fileName = \time() . '_' . ($newFileName ?? $this->getFilenameFromPath($pathOrUrl));
        $urlPath = $this->createUrlPath($this->baseDir, $code, $fileName);
        $url = $urlPath . '/' . $fileName;
        $this->copyFileToDestination($pathOrUrl, $this->baseDir . $url);

        /** @var File $item */
        $item = $this->create();
        $item->code = $code;
        $item->file_name = $fileName;
        $item->mime_type = $mimeType;
        $item->base_dir = $this->baseDir;
        $item->url = $url;
        $item->sort = $sort;
        $item->data = $data;
        $this->save($item);
        return $item;
    }

    /**
     * @param $id
     * @param AbstractEntity|null $item
     *
     * @return mixed
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function delete($id, AbstractEntity $item = null)
    {
        /** @var File $file */
        if ($file = $this->findById($id)) {
            $this->deleteFile($file);
        }
        return parent::delete($id, $item);
    }

    /**
     * @param Condition|null $condition
     *
     * @return mixed
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function deleteAll(Condition $condition = null)
    {
        $files = $this->findAll($condition);
        /** @var File $file */
        foreach ($files as $file) {
            $this->deleteFile($file);
        }
        return parent::deleteAll($condition);
    }

    /**
     * @return string
     */
    public function getBaseDir(): string
    {
        return $this->baseDir;
    }

    /**
     * @param string $baseDir
     */
    public function setBaseDir(string $baseDir)
    {
        $this->baseDir = \rtrim($baseDir, '/');
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param int $mode
     */
    public function setMode(int $mode)
    {
        $this->mode = $mode;
    }

    /**
     * @param File $file
     *
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    protected function deleteFile(File $file)
    {
        @\unlink($file->base_dir . $file->url);
        if (\file_exists($file->getCacheDir())) {
            $this->filesystem->remove($file->getCacheDir());
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function getFilenameFromPath(string $path): string
    {
        return \pathinfo(\parse_url($path, \PHP_URL_PATH), \PATHINFO_BASENAME);
    }

    /**
     * @param string $baseDir
     * @param string|null $code
     * @param string $fileName
     *
     * @return string
     */
    protected function createUrlPath($baseDir, $code, string $fileName): string
    {
        $subDir = \substr(\md5($code . $fileName), 0, 4);
        $fileUrl = $this->baseUrl . '/' . $subDir;
        $filePath = $baseDir . $fileUrl;
        @\mkdir($filePath, $this->mode, true);
        return $fileUrl;
    }

    /**
     * @param string $path
     * @param $dest
     *
     * @throws \Exception
     */
    protected function copyFileToDestination(string $path, $dest)
    {
        if (\strpos($path, 'http') === 0 || \strpos($path, 'ftp') === 0) {
            if (!\copy($path, $dest)) {
                throw new \RuntimeException('Cannot copy file: ' . $path . ' to ' . $dest);
            }
        } else {
            if (!\move_uploaded_file($path, $dest) && !\copy($path, $dest)) {
                throw new \RuntimeException('Cannot copy file: ' . $path . ' to ' . $dest);
            }
        }
    }

    /**
     * @param string $data
     *
     * @return string
     */
    protected function parseBase64Data(string $data): string
    {
        if ($data) {
            list(, $data) = \explode(';', $data);
            list(, $data) = \explode(',', $data);
            return \base64_decode($data) ?: '';
        }
        return $data;
    }
}

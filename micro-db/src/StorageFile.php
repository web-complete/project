<?php

namespace WebComplete\microDb;

class StorageFile implements StorageInterface
{

    /**
     * @var string
     */
    protected $file;
    /**
     * @var resource
     */
    protected $res;

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * @param bool $lock
     *
     * @return array
     * @throws \WebComplete\microDb\Exception
     */
    public function load(bool $lock): array
    {
        if (!\file_exists($this->file)) {
            $dir = \dirname($this->file);
            if (!\file_exists($dir)) {
                \mkdir($dir, 0700);
            }
            \touch($this->file);
        }

        if (!$this->res = \fopen($this->file, 'rb+')) {
            throw new Exception('Cannot open file: ' . $this->file);
        }

        if ($lock) {
            \flock($this->res, \LOCK_EX);
        }
        $content = null;
        if ($fileSize = \filesize($this->file)) {
            $content = \fread($this->res, $fileSize);
        }

        $lock ? \rewind($this->res) : \fclose($this->res);

        $data = \unserialize($content, ['allow_classes' => false]);
        return \is_array($data) ? $data : [];
    }

    /**
     * @param array $collectionData
     */
    public function save(array $collectionData)
    {
        \fwrite($this->res, \serialize($collectionData));
        \flock($this->res, \LOCK_UN);
        \fclose($this->res);
    }

    /**
     */
    public function drop()
    {
        if (\is_resource($this->res)) {
            \flock($this->res, \LOCK_UN);
            \fclose($this->res);
        }
        \unlink($this->file);
    }
}

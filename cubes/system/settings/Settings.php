<?php

namespace cubes\system\settings;

use WebComplete\core\utils\alias\AliasService;
use WebComplete\mvc\ApplicationConfig;

class Settings
{

    /**
     * @var array[]
     */
    protected $data = [];
    protected $structure = [];
    protected $isLoaded = false;
    protected $storagePath = '@storage/settings.json';

    /**
     * @var AliasService
     */
    private $aliasService;
    /**
     * @var ApplicationConfig
     */
    private $config;

    /**
     * @param ApplicationConfig $config
     * @param AliasService $aliasService
     */
    public function __construct(ApplicationConfig $config, AliasService $aliasService)
    {
        $this->aliasService = $aliasService;
        $this->config = $config;
    }

    /**
     * @param $code
     * @param null $default
     * @return mixed
     */
    public function get($code, $default = null)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        return $this->data[$code]['value'] ?? $default;
    }

    /**
     * @param $code
     * @param $value
     */
    public function set($code, $value)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        if (isset($this->data[$code])) {
            $this->data[$code]['value'] = $value;
            $this->save();
        }
    }

    /**
     *
     */
    public function load()
    {
        $settings = $this->config['settings'];
        $settingsStorageFile = $this->aliasService->get($this->storagePath);
        try {
            if ($settingsState = \file_get_contents($settingsStorageFile)) {
                $settingsState = (array)\json_decode($settingsState, true);
            }
        } catch (\Exception $e) {
            $settingsState = [];
        }

        $this->structure = $settings;
        $data = [];
        foreach ((array)$settings['data'] as $sectionSettings) {
            $data += $sectionSettings;
        }

        foreach ($settingsState as $code => $value) {
            $data[$code]['value'] = $value;
        }

        $this->data = $data;
        $this->isLoaded = true;
    }

    /**
     *
     */
    public function save()
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        $data = [];
        foreach ($this->data as $code => $row) {
            $data[$code] = $row['value'] ?? null;
        }
        $json = \json_encode($data, \JSON_PRETTY_PRINT);
        $settingsStorageFile = $this->aliasService->get($this->storagePath);
        \file_put_contents($settingsStorageFile, $json);
    }

    /**
     * @return array
     */
    public function getStructure(): array
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        /** @var array[] $result */
        $result = $this->structure;
        foreach ($this->data as $code => $row) {
            foreach ($result['data'] as &$sectionData) {
                if (isset($sectionData[$code])) {
                    $sectionData[$code] = $row;
                    break;
                }
            }
            unset($sectionData);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        $this->data = $data;
        $this->save();
    }

    /**
     * @return string
     */
    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    /**
     * @param string $storagePath
     */
    public function setStoragePath(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }
}

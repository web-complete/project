<?php

namespace cubes\system\settings;

use modules\admin\classes\fields\FieldAbstract;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\mvc\ApplicationConfig;

class Settings
{

    /**
     * @var FieldAbstract[]
     */
    protected $fields = [];
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
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        $result = isset($this->fields[$name]) ? $this->fields[$name]->getValue() : null;
        return $result ?? $default;
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        if (isset($this->fields[$name])) {
            $this->fields[$name]->value($value);
            $this->save();
        }
    }

    /**
     * @param $name
     *
     * @return FieldAbstract|null
     */
    public function getField($name)
    {
        return $this->fields[$name] ?? null;
    }

    /**
     *
     */
    public function load()
    {
        $settingsConfig = $this->config['settings'];
        $settingsStoragePath = $this->aliasService->get($this->storagePath);
        try {
            if ($settingsState = \file_get_contents($settingsStoragePath)) {
                $settingsState = (array)\json_decode($settingsState, true);
            }
        } catch (\Exception $e) {
            $settingsState = [];
        }

        $this->structure = $settingsConfig;
        /** @var FieldAbstract[] $fields */
        $fields = [];
        foreach ((array)$settingsConfig['fields'] as $sectionSettings) {
            $fields += $sectionSettings;
        }

        foreach ($settingsState as $name => $value) {
            $fields[$name]->value($value);
        }

        $this->fields = $fields;
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
        foreach ($this->fields as $name => $field) {
            $data[$name] = $field->getValue() ?? null;
        }
        $json = \json_encode($data, \JSON_PRETTY_PRINT);
        $settingsStorageFile = $this->aliasService->get($this->storagePath);
        \file_put_contents($settingsStorageFile, $json);
    }

    /**
     * @param bool $convertFieldsToArray
     *
     * @return array
     */
    public function getStructure(bool $convertFieldsToArray = false): array
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        /** @var array[] $result */
        $result = $this->structure;
        foreach ($result['sections'] as $name => $sectionName) {
            $result['sections'][$name] = [
                'title' => $sectionName,
                'name' => $name,
            ];
        }

        foreach ($this->fields as $name => $field) {
            foreach ($result['fields'] as &$sectionData) {
                if (isset($sectionData[$name])) {
                    $sectionData[$name] = $convertFieldsToArray ? $field->get() : $field;
                    break;
                }
            }
            unset($sectionData);
        }

        $result['sections'] = \array_values($result['sections']);
        foreach ($result['fields'] as $name => $rows) {
            $result['fields'][$name] = \array_values($rows);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        $this->fields = $fields;
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

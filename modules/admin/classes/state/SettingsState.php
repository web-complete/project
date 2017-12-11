<?php

namespace modules\admin\classes\state;

use cubes\system\file\File;
use cubes\system\file\FileService;
use cubes\system\settings\Settings;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\FieldType;

class SettingsState
{

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        $result = [];
        $structure = $this->settings->getStructure();
        foreach ((array)$structure['fields'] as $section) {
            /** @var FieldAbstract $item */
            foreach ((array)$section as $item) {
                $item->processField();
                $result[$item->getName()] = $item->getProcessedValue();
            }
        }
        return $result;
    }
}
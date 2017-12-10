<?php

namespace modules\admin\classes\state;

use cubes\system\file\File;
use cubes\system\file\FileService;
use cubes\system\settings\Settings;
use modules\admin\classes\FieldType;

class SettingsState
{

    /**
     * @var Settings
     */
    private $settings;
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @param Settings $settings
     * @param FileService $fileService
     */
    public function __construct(Settings $settings, FileService $fileService)
    {
        $this->settings = $settings;
        $this->fileService = $fileService;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        $result = [];
        $structure = $this->settings->getStructure();
        foreach ((array)$structure['data'] as $section) {
            foreach ((array)$section as $item) {
                $code = $item['code'];
                $result[$code] = $item['value'] ?? null;
                if ($result[$code] && $item['field'] === FieldType::FILE) {
                    /** @var File $file */
                    $file = $this->fileService->findById($result[$code]);
                    $result[$code] = $file ? $file->url : '';
                }
            }
        }
        return $result;
    }
}
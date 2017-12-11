<?php

namespace modules\admin\classes\fields;

use cubes\system\file\File;
use cubes\system\file\FileService;

class FieldFile extends FieldAbstract
{

    protected $data = [
        'component' => 'VueFieldFile',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'data' => [],
            'multiple' => false
        ]
    ];

    /**
     * @param $title
     * @param $name
     */
    public function __construct($title, $name)
    {
        $this->data['title'] = $title;
        $this->data['name'] = $name;
    }

    /**
     * @return mixed|null
     */
    public function getProcessedValue()
    {
        $this->processField();
        return $this->getUrl();
    }

    public function processField()
    {
        global $application;
        $fileService = $application->getContainer()->get(FileService::class);

        if ($fileId = $this->getValue()) {
            $fileIds = (array)$fileId;
            foreach ($fileIds as $fileId) {
                /** @var File $file */
                if ($file = $fileService->findById($fileId)) {
                    $this->data['fieldParams']['data'][$fileId] = \array_merge((array)$file->data, [
                        'name' => $file->file_name,
                        'url' => $file->url,
                    ]);
                }
            }
        }
    }

    /**
     * @return array|string|null
     */
    public function getUrl()
    {
        $result = [];
        $this->processField();
        foreach ((array)$this->data['fieldParams']['data'] as $id => $data) {
            $result[$id] = $data['url'] ?? null;
        }
        return $this->data['fieldParams']['multiple']
            ? $result
            : \reset($result);
    }
}

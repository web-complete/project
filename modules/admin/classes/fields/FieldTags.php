<?php

namespace modules\admin\classes\fields;

use cubes\system\tags\Tag;
use cubes\system\tags\TagService;

class FieldTags extends FieldAbstract
{

    protected $data = [
        'component' => 'VueFieldTags',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'namespace' => '',
            'selectedTags' => ['tag2'],
            'availableTags' => ['tag1', 'tag2', 'tag3'],
        ]
    ];
    /**
     * @var TagService
     */
    protected $tagService;

    /**
     * @param string $title
     * @param string $name
     * @param string $namespace
     * @param TagService $tagService
     */
    public function __construct(string $title, string $name, string $namespace, TagService $tagService)
    {
        $this->tagService = $tagService;
        $this->data['title'] = $title;
        $this->data['name'] = $name;
        $this->data['fieldParams']['namespace'] = $namespace;
//        $this->data['fieldParams']['availableTags'] = $this->getAvailableTags($namespace);
    }

    /**
     * @param string $namespace
     *
     * @return string[]
     */
    protected function getAvailableTags(string $namespace): array
    {
        $result = [];
        $condition = $this->tagService->createCondition(['namespace' => $namespace]);
        /** @var Tag[] $tags */
        $tags = $this->tagService->findAll($condition);
        foreach ($tags as $tag) {
            $result[] = $tag->name;
        }
        return $result;
    }
}

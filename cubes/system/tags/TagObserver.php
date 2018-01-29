<?php

namespace cubes\system\tags;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class TagObserver
{
    /**
     * @var TagService
     */
    protected $tagService;
    /**
     * @var AbstractEntityService
     */
    protected $entityService;
    protected $tagField;

    /**
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @param AbstractEntityService $entityService
     * @param string $tagField
     */
    public function listen(AbstractEntityService $entityService, string $tagField)
    {
        $this->entityService = $entityService;
        $this->tagField = $tagField;
        $this->listenSave();
        $this->listenDelete();
    }

    protected function listenSave()
    {
        $this->entityService->on(AbstractEntityService::EVENT_SAVE_AFTER, function (array $eventData) {
            /** @var AbstractEntity $item */
            if ($item = $eventData['item'] ?? null) {
                /** @var array $oldData */
                $oldData = isset($eventData['oldData']) ? (array)$eventData['oldData'] : [];
                $oldTagsValue = $oldData[$this->tagField] ?? '';
                $newTagsValue = (string)$item->get($this->tagField);
                $oldTags = $oldTagsValue ? \explode(',', $oldTagsValue) : [];
                $newTags = $newTagsValue ? \explode(',', $newTagsValue) : [];
                foreach (\array_diff($oldTags, $newTags) as $oldTag) {
                    $this->tagService->detachTag($oldTag, \get_class($this->entityService), $item->getId());
                }
                foreach (\array_diff($newTags, $oldTags) as $newTag) {
                    $this->tagService->attachTag($newTag, \get_class($this->entityService), $item->getId());
                }
            }
        });
    }

    protected function listenDelete()
    {
        $this->entityService->on(AbstractEntityService::EVENT_DELETE_BEFORE, function (array $eventData) {
            if ($id = $eventData['id'] ?? null) {
                if (!$item = $eventData['item'] ?? null) {
                    $item = $this->entityService->findById($id);
                }

                if ($tags = (string)$item->get($this->tagField)) {
                    foreach (\explode(',', $tags) as $tag) {
                        $this->tagService->detachTag($tag, \get_class($this->entityService), $id);
                    }
                }
            }
        });
    }
}

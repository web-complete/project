<?php

namespace cubes\seo\seo;

use cubes\seo\slug\Slug;
use cubes\seo\slug\SlugService;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class SeoEntityObserver
{
    /**
     * @var SlugService
     */
    protected $slugService;
    /**
     * @var AbstractEntityService
     */
    protected $entityService;
    /**
     * @var AbstractEntitySeo
     */
    protected $entitySeo;

    /**
     * @param SlugService $slugService
     */
    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    /**
     * @param AbstractEntityService $entityService
     * @param AbstractEntitySeo $entitySeo
     */
    public function listen(AbstractEntityService $entityService, AbstractEntitySeo $entitySeo)
    {
        $this->entityService = $entityService;
        $this->entitySeo = $entitySeo;
        $this->listenSave();
        $this->listenDelete();
    }

    protected function listenSave()
    {
        $this->entityService->on(AbstractEntityService::EVENT_SAVE_AFTER, function (array $eventData) {
            /** @var AbstractEntity $item */
            if ($item = $eventData['item'] ?? null) {
                $this->entitySeo->setCurrentItem($item);
                $condition = $this->slugService->createCondition([
                    'item_class' => \get_class($this->entitySeo),
                    'item_id' => $item->getId(),
                ]);
                /** @var Slug $slugItem */
                if (!$slugItem = $this->slugService->findOne($condition)) {
                    $slugItem = $this->slugService->create();
                    $slugItem->item_class = \get_class($this->entitySeo);
                    $slugItem->item_id = $item->getId();
                }
                $slugItem->name = $this->entitySeo->getSlug(true);
                $this->slugService->save($slugItem);
            }
        });
    }

    protected function listenDelete()
    {
        $this->entityService->on(AbstractEntityService::EVENT_DELETE_AFTER, function (array $eventData) {
            if ($id = $eventData['id'] ?? null) {
                $condition = $this->slugService->createCondition([
                    'item_class' => \get_class($this->entitySeo),
                    'item_id' => $id,
                ]);
                if ($slugItem = $this->slugService->findOne($condition)) {
                    $this->slugService->delete($slugItem->getId());
                }
            }
        });
    }
}

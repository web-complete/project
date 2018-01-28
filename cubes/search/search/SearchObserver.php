<?php

namespace cubes\search\search;

use WebComplete\core\entity\AbstractEntityService;

class SearchObserver
{
    /**
     * @var SearchService
     */
    protected $searchService;
    /**
     * @var AbstractEntityService
     */
    protected $entityService;

    /**
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @param AbstractEntityService $entityService
     */
    public function listen(AbstractEntityService $entityService)
    {
        $this->entityService = $entityService;
        $this->listenSave();
        $this->listenDelete();
    }

    protected function listenSave()
    {
        $this->entityService->on(AbstractEntityService::EVENT_SAVE_AFTER, function (array $eventData) {
            /** @var Searchable $item */
            if ($item = $eventData['item'] ?? null) {
                $doc = $this->searchService->createDoc();
                $item->prepareSearchDoc($doc);
                $this->searchService->indexDoc($doc);
            }
        });
    }

    protected function listenDelete()
    {
        $this->entityService->on(AbstractEntityService::EVENT_DELETE_AFTER, function (array $eventData) {
            if ($id = $eventData['id'] ?? null) {
                $this->searchService->deleteDoc($id);
            }
        });
    }
}

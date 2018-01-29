<?php

namespace cubes\search\search;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class SearchObserver
{
    /**
     * @var SearchService
     */
    protected $searchService;
    /**
     * @var SearchEntityIndexer
     */
    protected $entityIndexer;
    /**
     * @var AbstractEntityService
     */
    protected $entityService;

    /**
     * @param SearchService $searchService
     * @param SearchEntityIndexer $entityIndexer
     */
    public function __construct(SearchService $searchService, SearchEntityIndexer $entityIndexer)
    {
        $this->searchService = $searchService;
        $this->entityIndexer = $entityIndexer;
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
            /** @var AbstractEntity $item */
            if ($item = $eventData['item'] ?? null) {
                $this->entityIndexer->index($item);
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

                $doc = $this->searchService->createDoc();
                $item->prepareSearchDoc($doc);
                $this->searchService->deleteDoc($doc->type, $id);
            }
        });
    }
}

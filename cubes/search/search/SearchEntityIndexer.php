<?php

namespace cubes\search\search;

use cubes\multilang\lang\classes\AbstractMultilangEntity;
use cubes\multilang\lang\LangService;
use WebComplete\core\entity\AbstractEntity;

class SearchEntityIndexer
{
    /**
     * @var SearchService
     */
    protected $searchService;
    /**
     * @var LangService
     */
    protected $langService;

    /**
     * @param SearchService $searchService
     * @param LangService $langService
     */
    public function __construct(SearchService $searchService, LangService $langService)
    {
        $this->searchService = $searchService;
        $this->langService = $langService;
    }

    public function index(AbstractEntity $item)
    {
        if (!$item instanceof Searchable) {
            throw new \RuntimeException(\get_class($item) . ' is not an implementation of ' . Searchable::class);
        }
        if ($item instanceof AbstractMultilangEntity) {
            $langs = $this->langService->getLangs();
            foreach ($langs as $lang) {
                $doc = $this->searchService->createDoc();
                $item->setLang($lang->code);
                $item->prepareSearchDoc($doc);
                $doc->lang_code = $lang->code;
                $this->searchService->indexDoc($doc);
            }
            $item->setLang();
        } else {
            $doc = $this->searchService->createDoc();
            $item->prepareSearchDoc($doc);
            $doc->lang_code = null;
            $this->searchService->indexDoc($doc);
        }
    }
}

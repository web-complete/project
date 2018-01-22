<?php

namespace cubes\multilang\translation\admin;

use cubes\multilang\lang\LangService;
use cubes\multilang\translation\TranslationConfig;
use modules\admin\controllers\AbstractEntityController;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\paginator\Paginator;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = TranslationConfig::class;
    protected $defaultSortField = 'namespace';

    /**
     * @param $entityService
     * @param $paginator
     * @param $condition
     *
     * @return array
     */
    protected function fetchRawListItems(
        AbstractEntityService $entityService,
        Paginator $paginator,
        Condition $condition
    ): array {
        $rawItems = [];
        $langService = $this->container->get(LangService::class);
        $langs = $langService->getLangs();
        foreach ($entityService->list($paginator, $condition) as $item) {
            $rawItem = $item->mapToArray();
            foreach ($langs as $lang) {
                $rawItem['has_translation_' . $lang->code] = (bool)($rawItem['translations'][$lang->code] ?? null);
            }
            $rawItems[] = $rawItem;
        }

        return $rawItems;
    }
}

<?php

namespace cubes\content\staticBlock\admin;

use cubes\content\staticBlock\StaticBlock;
use cubes\content\staticBlock\StaticBlockConfig;
use cubes\content\staticBlock\StaticBlockService;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\controllers\AbstractEntityController;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\paginator\Paginator;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = StaticBlockConfig::class;
    protected $defaultSortField = 'namespace';
    protected $defaultSortDir = 'asc';

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
        foreach ($entityService->list($paginator, $condition) as $item) {
            /** @var StaticBlock $item */
            $rawItem = $item->mapToArray();
            $rawItem['type'] = StaticBlockService::$typeMap[$item->type] ?? '';
            $rawItems[] = $rawItem;
        }

        return $rawItems;
    }

    /**
     * @param FieldAbstract[] $detailFields
     * @param AbstractEntity|StaticBlock $item
     *
     * @return array
     */
    protected function detailFieldsProcess(array $detailFields, AbstractEntity $item): array
    {
        // dynamically add "content" field based on "type"
        $fields = FieldFactory::build();
        switch ($item->type) {
            case StaticBlockService::TYPE_STRING:
                $detailFields[] = $fields->string('Содержание', 'content');
                break;
            case StaticBlockService::TYPE_TEXT:
                $detailFields[] = $fields->redactor('Содержание', 'content');
                break;
            case StaticBlockService::TYPE_HTML:
                $detailFields[] = $fields->html('Содержание', 'content');
                break;
            case StaticBlockService::TYPE_IMAGE:
                $detailFields[] = $fields->image('Содержание', 'content');
                break;
            case StaticBlockService::TYPE_IMAGES:
                $detailFields[] = $fields->image('Содержание', 'content')->multiple(true);
                break;
        }

        return parent::detailFieldsProcess($detailFields, $item);
    }
}

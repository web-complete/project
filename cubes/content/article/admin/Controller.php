<?php

namespace cubes\content\article\admin;

use cubes\content\article\ArticleConfig;
use modules\admin\controllers\AbstractEntityController;
use WebComplete\core\condition\Condition;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = ArticleConfig::class;

    /**
     * @param Condition $condition
     */
    protected function prepareListCondition(Condition $condition)
    {
        $sortField = $this->request->get('sortField', 'published_on') ?: 'published_on';
        $sortDir = $this->request->get('sortDir', 'desc') ?: 'desc';
        $condition->addSort($sortField, $sortDir === 'desc' ? \SORT_DESC : \SORT_ASC);
    }
}

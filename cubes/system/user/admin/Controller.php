<?php

namespace cubes\system\user\admin;

use cubes\system\user\User;
use cubes\system\user\UserConfig;
use modules\admin\controllers\AbstractEntityController;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\paginator\Paginator;
use WebComplete\form\AbstractForm;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = UserConfig::class;

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
            /** @var User $item */
            $rawItem = $item->mapToArray();
            $rawItem['roles'] = \implode(', ', \array_keys($item->getRoles()));
            $rawItems[] = $rawItem;
        }

        return $rawItems;
    }

    /**
     * @param AbstractEntity|User $item
     * @param AbstractForm $form
     *
     * @return bool
     */
    protected function beforeSave(AbstractEntity $item, AbstractForm $form): bool
    {
        if (parent::beforeSave($item, $form)) {
            if ($newPassword = $form->getValue('new_password')) {
                $item->setNewPassword($newPassword);
            }
            return true;
        }
        return false;
    }
}

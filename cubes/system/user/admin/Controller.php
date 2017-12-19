<?php

namespace cubes\system\user\admin;

use cubes\system\user\User;
use cubes\system\user\UserConfig;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\controllers\AbstractEntityController;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\paginator\Paginator;
use WebComplete\form\AbstractForm;
use WebComplete\rbac\Rbac;

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
     * @param FieldAbstract[] $detailFields
     * @param AbstractEntity|User $item
     *
     * @return array
     */
    protected function detailFieldsProcess(array $detailFields, AbstractEntity $item): array
    {
        $result = [];
        foreach ($detailFields as $field) {
            if ($field->getName() === 'roles') {
                $field->value(\array_keys($item->getRoles()));
            } else {
                $field->value($item->get($field->getName()));
            }
            $field->processField();
            $result[] = $field->get();
        }
        return $result;
    }

    /**
     * @param AbstractEntity|User $item
     * @param AbstractForm $form
     *
     * @return bool
     */
    protected function beforeSave(AbstractEntity $item, AbstractForm $form): bool
    {
        $item->mapFromArray($form->getData(), true);
        if ($newPassword = $form->getValue('new_password')) {
            $item->setNewPassword($newPassword);
        }

        return true;
    }

    /**
     * @param AbstractEntity|User $item
     * @param AbstractForm $form
     *
     * @throws \WebComplete\rbac\exception\RbacException
     */
    protected function afterSave(AbstractEntity $item, AbstractForm $form)
    {
        $oldRoleNames = \array_keys($item->getRoles());
        $newRoleNames = (array)$form->getValue('roles');
        $rbac = $this->container->get(Rbac::class);
        foreach ($rbac->getRoles() as $role) {
            $roleName = $role->getName();
            if (\in_array($roleName, $newRoleNames, true) && !\in_array($roleName, $oldRoleNames, true)) {
                $role->assignUserId($item->getId());
            }
            if (!\in_array($roleName, $newRoleNames, true) && \in_array($roleName, $oldRoleNames, true)) {
                $role->removeUserId($item->getId());
            }
        }
        $rbac->save();
    }
}

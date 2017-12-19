<?php

namespace cubes\system\roles\admin;

use modules\admin\classes\cells\Cell;
use modules\admin\classes\fields\Field;
use modules\admin\classes\form\AdminForm;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\rbac\entity\RoleInterface;
use WebComplete\rbac\Rbac;

class Controller extends AbstractController
{

    protected $messageFormError = 'Ошибка валидации формы';
    protected $messageNotFound = 'Роль не найдена';

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionList(): Response
    {
        $rawItems = [];
        $rbac = $this->container->get(Rbac::class);
        foreach ($rbac->getRoles() as $role) {
            $descriptions = [];
            foreach ($role->getPermissions() as $permission) {
                $descriptions[] = $permission->getDescription();
            }
            $rawItems[] = [
                'name' => $role->getName(),
                'permissions' => \implode('<br>', $descriptions),
            ];
        }

        $listFields = [
            Cell::string('Название', 'name')->get(),
            Cell::string('Права', 'permissions')->get(),
        ];

        return $this->responseJsonSuccess([
            'listFields' => $listFields,
            'items' => $rawItems,
        ]);
    }

    /**
     * @param string $id
     * @return Response
     * @throws \Exception
     */
    public function actionDetail($id): Response
    {
        $rbac = $this->container->get(Rbac::class);
        $roleId = (string)$id;
        if (!$role = $rbac->getRole($roleId)) {
            $role = $rbac->createRole('');
        }

        $detailFields = [
            Field::string('Название', 'name')
                ->disabled((bool)$role->getName())
                ->filter('^[a-z_]*$')
                ->value($roleId)
                ->get(),
            Field::select('Права', 'permissions')
                ->multiple()
                ->options($this->getAllPermissionsMap($rbac))
                ->value($this->getRolePermissionNames($role))
                ->get(),
        ];

        return $this->responseJsonSuccess([
            'detailFields' => $detailFields,
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSave(): Response
    {
        $rbac = $this->container->get(Rbac::class);

        $data = $this->request->request->all();
        $form = new AdminForm([
            [['name'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['permissions']],
        ]);
        $form->setData($data);
        if ($form->validate()) {
            if ($roleId = (string)$this->request->get('id')) {
                if (!$role = $rbac->getRole($roleId)) {
                    return $this->responseJsonFail($this->messageNotFound);
                }
            } else {
                $role = $rbac->createRole($form->getValue('name'));
            }

            foreach ($role->getPermissions() as $permission) {
                $role->removePermission($permission->getName());
            }
            foreach ((array)$form->getValue('permissions') as $permissionName) {
                if ($permission = $rbac->getPermission($permissionName)) {
                    $role->addPermission($permission);
                }
            }
            $rbac->save();
            return $this->responseJsonSuccess();
        }

        return $this->responseJsonFail($this->messageFormError, ['errors' => $form->getFirstErrors()]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionDelete(): Response
    {
        $rbac = $this->container->get(Rbac::class);
        $roleId = (string)$this->request->get('id');
        if ($roleId && ($role = $rbac->getRole($roleId))) {
            $rbac->deleteRole($role->getName());
            $rbac->save();
        }

        return $this->responseJsonSuccess();
    }

    /**
     * @param Rbac $rbac
     *
     * @return array
     */
    protected function getAllPermissionsMap(Rbac $rbac): array
    {
        $result = [];
        foreach ($rbac->getPermissions() as $permission) {
            $result[$permission->getName()] = $permission->getDescription();
        }
        return $result;
    }

    /**
     * @param RoleInterface $role
     *
     * @return array
     */
    protected function getRolePermissionNames(RoleInterface $role): array
    {
        $result = [];
        foreach ($role->getPermissions() as $permission) {
            $result[] = $permission->getName();
        }
        return $result;
    }
}

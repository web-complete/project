<?php

namespace cubes\system\user;

use cubes\system\user\controllers\UserController;
use modules\admin\classes\cells\Cell;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\Filter;
use modules\admin\classes\filter\FilterField;
use WebComplete\core\utils\typecast\Cast;
use WebComplete\rbac\Rbac;

class UserConfig extends EntityConfig
{
    public $name = 'user';
    public $titleList = 'Пользователи';
    public $titleDetail = 'Пользователь';
    public $entityServiceClass = UserService::class;
    public $controllerClass = UserController::class;
    public $menuSectionName = 'Система';

    /**
     * @return array
     */
    public static function fieldTypes(): array
    {
        return [
            'login' => Cast::STRING,
            'email' => Cast::STRING,
            'password' => Cast::STRING,
            'token' => Cast::STRING,
            'first_name' => Cast::STRING,
            'last_name' => Cast::STRING,
            'sex' => Cast::STRING,
            'last_visit' => Cast::STRING,
            'is_active' => Cast::BOOL,
            'roles' => [Cast::STRING],
            'created_on' => Cast::STRING,
            'updated_on' => Cast::STRING,
        ];
    }

    /**
     * @return CellAbstract[]
     */
    public function listFields(): array
    {
        return [
            Cell::string('ID', 'id', \SORT_DESC)->get(),
            Cell::checkbox('Активность', 'is_active', \SORT_DESC)->get(),
            Cell::string('Логин', 'login')->get(),
            Cell::string('E-mail', 'email')->get(),
            Cell::string('Роли', 'roles')->get(),
            Cell::string('Имя', 'full_name')->get(),
            Cell::sex('Пол', 'sex', \SORT_ASC)->get(),
            Cell::date('Последний визит', 'last_visit', \SORT_DESC)->get(),
            Cell::date('Создание', 'created_on', \SORT_DESC)->get(),
            Cell::date('Обновление', 'updated_on', \SORT_DESC)->get(),
        ];
    }

    /**
     * @return FilterField[]
     */
    public function filterFields(): array
    {
        return [
            Filter::string('ID', 'id', Filter::MODE_EQUAL),
            Filter::string('Логин', 'login', Filter::MODE_EQUAL),
            Filter::string('E-mail', 'email', Filter::MODE_LIKE),
            Filter::boolean('Активность', 'is_active'),
            Filter::select('Роль', 'roles', $this->getAvailableRolesMap())
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function detailFields(): array
    {
        return [

        ];
    }

    public function form()
    {
        return [

        ];
    }

    /**
     * @return array
     */
    protected function getAvailableRolesMap(): array
    {
        $rolesMap = [];
        $rbac = $this->container->get(Rbac::class);
        foreach ($rbac->getRoles() as $role) {
            $name = $role->getName();
            $rolesMap[$name] = $name;
        };
        return $rolesMap;
    }
}
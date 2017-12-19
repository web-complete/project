<?php

namespace cubes\system\user;

use cubes\system\user\admin\Controller;
use modules\admin\classes\cells\Cell;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\Field;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\Filter;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;
use WebComplete\form\AbstractForm;
use WebComplete\rbac\Rbac;

class UserConfig extends EntityConfig
{
    public $name = 'user';
    public $titleList = 'Пользователи';
    public $titleDetail = 'Пользователь';
    public $entityServiceClass = UserService::class;
    public $controllerClass = Controller::class;
    public $menuSectionName = 'Система';

    /**
     * @return array
     */
    public static function getFieldTypes(): array
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
            'created_on' => Cast::STRING,
            'updated_on' => Cast::STRING,
        ];
    }

    /**
     * @return CellAbstract[]
     */
    public function getListFields(): array
    {
        return [
            Cell::string('ID', 'id', \SORT_DESC),
            Cell::checkbox('Активность', 'is_active', \SORT_DESC),
            Cell::string('Логин', 'login'),
            Cell::string('E-mail', 'email'),
            Cell::string('Роли', 'roles'),
            Cell::string('Имя', 'full_name'),
            Cell::sex('Пол', 'sex', \SORT_ASC),
            Cell::date('Последний визит', 'last_visit', \SORT_DESC),
            Cell::date('Создание', 'created_on', \SORT_DESC),
            Cell::date('Обновление', 'updated_on', \SORT_DESC),
        ];
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
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
    public function getDetailFields(): array
    {
        return [
            Field::string('Логин', 'login'),
            Field::string('E-mail', 'email'),
            Field::string('Пароль', 'new_password'),
            Field::string('Имя', 'first_name')->filter('^[a-zA-Zа-яА-Я\s]*$'),
            Field::string('Фамилия', 'last_name')->filter('^[a-zA-Zа-яА-Я\s]*$'),
            Field::select('Пол', 'sex')->options(['M' => 'мужской', 'F' => 'женский']),
            Field::select('Роли', 'roles')->multiple(true)->options($this->getAvailableRolesMap()),
            Field::checkbox('Активность', 'is_active'),
        ];
    }

    /**
     * @return AbstractForm
     */
    public function getForm(): AbstractForm
    {
        return new AdminForm([
            [['login', 'email', 'sex'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['email'], 'email', [], AdminForm::MESSAGE_INCORRECT],
            [['new_password', 'first_name', 'last_name', 'roles', 'is_active']],
        ]);
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
        }
        return $rolesMap;
    }
}

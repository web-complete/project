<?php

namespace cubes\system\user;

use cubes\system\user\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
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
        $cells = CellFactory::build();
        return [
            $cells->string('ID', 'id', \SORT_DESC),
            $cells->checkbox('Активность', 'is_active', \SORT_DESC),
            $cells->string('Логин', 'login'),
            $cells->string('E-mail', 'email'),
            $cells->string('Роли', 'roles'),
            $cells->string('Имя', 'full_name'),
            $cells->sex('Пол', 'sex', \SORT_ASC),
            $cells->dateTime('Последний визит', 'last_visit', \SORT_DESC),
            $cells->dateTime('Создание', 'created_on', \SORT_DESC),
            $cells->dateTime('Обновление', 'updated_on', \SORT_DESC),
        ];
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
    {
        $filters = FilterFactory::build();
        return [
            $filters->string('ID', 'id', FilterFactory::MODE_EQUAL),
            $filters->string('Логин', 'login', FilterFactory::MODE_EQUAL),
            $filters->string('E-mail', 'email', FilterFactory::MODE_LIKE),
            $filters->boolean('Активность', 'is_active'),
            $filters->select('Роль', 'roles', $this->getAvailableRolesMap())
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Логин', 'login'),
            $fields->string('E-mail', 'email'),
            $fields->string('Пароль', 'new_password'),
            $fields->string('Имя', 'first_name')->filter('^[a-zA-Zа-яА-Я\s]*$'),
            $fields->string('Фамилия', 'last_name')->filter('^[a-zA-Zа-яА-Я\s]*$'),
            $fields->select('Пол', 'sex')->options(['M' => 'мужской', 'F' => 'женский']),
            $fields->select('Роли', 'roles')->multiple(true)->options($this->getAvailableRolesMap()),
            $fields->checkbox('Активность', 'is_active'),
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

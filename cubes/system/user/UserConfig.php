<?php

namespace cubes\system\user;

use modules\admin\classes\cells\Cell;
use modules\admin\classes\EntityConfig;
use WebComplete\core\utils\typecast\Cast;

class UserConfig extends EntityConfig
{

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
}

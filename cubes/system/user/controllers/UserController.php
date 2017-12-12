<?php

namespace cubes\system\user\controllers;

use cubes\system\user\UserService;
use modules\admin\classes\cells\Cell;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntityService;

class UserController extends AbstractController
{

    protected $titleList = 'Пользователи';
    protected $itemsPerPage = 25;
    protected $entityServiceClass = UserService::class;

    /**
     * @return array
     */
    protected function listFields(): array
    {
        return [
            Cell::string('ID', 'id', \SORT_ASC)->get(),
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
     * @return Response
     * @throws \Exception
     */
    public function actionList(): Response
    {
        /** @var AbstractEntityService $entityService */
        $entityService = $this->container->get($this->entityServiceClass);
        $condition = $this->container->make(Condition::class);
        $rawItems = [];
        foreach ($entityService->findAll($condition) as $item) {
            $rawItem = $item->mapToArray();
            $rawItem['roles'] = \implode(', ', $rawItem['roles']);
            $rawItems[] = $rawItem;
        }

        return $this->responseJsonSuccess([
            'title' => $this->titleList,
            'page' => 1,
            'itemsPerPage' => $this->itemsPerPage,
            'itemsTotal' => \count($rawItems),
            'fields' => $this->listFields(),
            'items' => $rawItems
        ]);
    }
}
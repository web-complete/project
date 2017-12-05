<?php

namespace admin\controllers;

use admin\classes\Navigation;
use admin\classes\state\UserState;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class IndexController extends AbstractController
{
    /**
     * @var UserState
     */
    private $userState;
    /**
     * @var Navigation
     */
    private $navigation;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param UserService $userService
     * @param UserState $userState
     * @param Navigation $navigation
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        UserService $userService,
        UserState $userState,
        Navigation $navigation
    ) {
        parent::__construct($request, $response, $view, $userService);
        $this->userState = $userState;
        $this->navigation = $navigation;
    }

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $userState = $this->userState->getState();
        $navigation = $this->navigation->get();

        return $this->responseHtml('@admin/views/index/index.php', [
            'userState' => $userState,
            'navigation' => $navigation,
        ]);
    }
}

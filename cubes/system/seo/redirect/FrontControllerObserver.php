<?php

namespace cubes\system\seo\redirect;

use WebComplete\mvc\front\FrontController;

class FrontControllerObserver
{

    /**
     * @var FrontController
     */
    private $frontController;
    /**
     * @var RedirectService
     */
    private $redirectService;

    /**
     * @param FrontController $frontController
     * @param RedirectService $redirectService
     */
    public function __construct(FrontController $frontController, RedirectService $redirectService)
    {
        $this->frontController = $frontController;
        $this->redirectService = $redirectService;
    }

    /**
     */
    public function listen()
    {
        $this->frontController->on(FrontController::EVENT_DISPATCH_BEFORE, function () {
            if ($redirectUrl = $this->redirectService->getRedirectUrl()) {
                \header('HTTP/1.1 301 Moved Permanently');
                \header('Location: ' . $redirectUrl);
                exit();
            }
        });
    }
}
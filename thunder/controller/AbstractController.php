<?php

namespace WebComplete\thunder\controller;

use WebComplete\thunder\view\ViewInterface;

class AbstractController
{

    protected $layout;

    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view)
    {
        $view->setController($this);
        $this->view = $view;
    }

    /**
     * @param $templatePath
     * @param array $vars
     *
     * @return string
     * @throws \Exception
     */
    public function render($templatePath, array $vars = []): string
    {
        return $this->view->layout($this->layout)->render($templatePath, $vars);
    }

    /**
     * @param $templatePath
     * @param array $vars
     *
     * @return string
     * @throws \Exception
     */
    public function partial($templatePath, array $vars = []): string
    {
        return $this->view->layout()->render($templatePath, $vars);
    }
}

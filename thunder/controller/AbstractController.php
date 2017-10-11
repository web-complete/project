<?php

namespace WebComplete\thunder\controller;

use WebComplete\thunder\controller\response\ResponseAccessDenied;
use WebComplete\thunder\controller\response\ResponseHtml;
use WebComplete\thunder\controller\response\ResponseJson;
use WebComplete\thunder\controller\response\ResponseNotFound;
use WebComplete\thunder\controller\response\ResponseRedirect;
use WebComplete\thunder\view\ViewInterface;

abstract class AbstractController
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
     * @return ResponseHtml
     * @throws \Exception
     */
    public function responseHtml($templatePath, array $vars = []): ResponseHtml
    {
        $html = $this->view->layout($this->layout)->render($templatePath, $vars);
        return new ResponseHtml($html);
    }

    /**
     * @param $templatePath
     * @param array $vars
     *
     * @return ResponseHtml
     * @throws \Exception
     */
    public function responseHtmlPartial($templatePath, array $vars = []): ResponseHtml
    {
        $html = $this->view->layout()->render($templatePath, $vars);
        return new ResponseHtml($html);
    }

    /**
     * @param array $data
     *
     * @return ResponseJson
     */
    public function responseJson(array $data): ResponseJson
    {
        return new ResponseJson($data);
    }

    /**
     * @param string $url
     * @param int $code
     * @param array $headers
     *
     * @return ResponseRedirect
     */
    public function responseRedirect(string $url, int $code = 302, array $headers = []): ResponseRedirect
    {
        return new ResponseRedirect($url, $code, $headers);
    }

    /**
     * @return ResponseNotFound
     */
    public function responseNotFound(): ResponseNotFound
    {
        return new ResponseNotFound();
    }

    /**
     * @return ResponseAccessDenied
     */
    public function responseAccessDenied(): ResponseAccessDenied
    {
        return new ResponseAccessDenied();
    }
}

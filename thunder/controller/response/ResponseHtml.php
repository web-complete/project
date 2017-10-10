<?php

namespace WebComplete\thunder\controller\response;

class ResponseHtml implements ControllerResponseInterface
{
    /**
     * @var
     */
    private $html;

    /**
     * @param string $html
     */
    public function __construct(string $html)
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->html;
    }
}

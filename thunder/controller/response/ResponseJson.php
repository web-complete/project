<?php

namespace WebComplete\thunder\controller\response;

class ResponseJson implements ControllerResponseInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->data;
    }
}

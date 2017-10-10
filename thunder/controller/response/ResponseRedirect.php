<?php

namespace WebComplete\thunder\controller\response;

class ResponseRedirect implements ControllerResponseInterface
{
    private $url;
    private $code;
    private $headers;

    /**
     * @param string $url
     * @param int $code
     * @param array $headers
     */
    public function __construct(string $url, int $code, array $headers = [])
    {
        $this->url = $url;
        $this->code = $code;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}

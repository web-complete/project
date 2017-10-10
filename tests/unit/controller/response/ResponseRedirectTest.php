<?php

namespace tests\unit\controller\response;

use WebComplete\thunder\controller\response\ControllerResponseInterface;
use PHPUnit\Framework\TestCase;
use WebComplete\thunder\controller\response\ResponseJson;
use WebComplete\thunder\controller\response\ResponseRedirect;

class ResponseRedirectTest extends TestCase
{

    public function testInstance()
    {
        $response = new ResponseRedirect('some url', 111, ['aaa' => 'bbb']);
        $this->assertInstanceOf(ControllerResponseInterface::class, $response);
        $this->assertEquals('some url', $response->getUrl());
        $this->assertEquals(111, $response->getCode());
        $this->assertEquals(['aaa' => 'bbb'], $response->getHeaders());
    }
}

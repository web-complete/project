<?php

namespace tests\unit\controller\response;

use WebComplete\thunder\controller\response\ControllerResponseInterface;
use WebComplete\thunder\controller\response\ResponseHtml;
use PHPUnit\Framework\TestCase;

class ResponseHtmlTest extends TestCase
{

    public function testInstance()
    {
        $response = new ResponseHtml('some url');
        $this->assertInstanceOf(ControllerResponseInterface::class, $response);
        $this->assertEquals('some url', $response->getContent());
    }
}

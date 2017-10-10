<?php

namespace tests\unit\controller\response;

use WebComplete\thunder\controller\response\ControllerResponseInterface;
use PHPUnit\Framework\TestCase;
use WebComplete\thunder\controller\response\ResponseJson;

class ResponseJsonTest extends TestCase
{

    public function testInstance()
    {
        $response = new ResponseJson([1,2,3]);
        $this->assertInstanceOf(ControllerResponseInterface::class, $response);
        $this->assertEquals([1,2,3], $response->getContent());
    }
}

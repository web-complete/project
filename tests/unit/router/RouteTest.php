<?php

namespace tests\unit\router;

use tests\ThunderTestCase;
use WebComplete\mvc\router\Route;

class RouteTest extends ThunderTestCase
{

    public function testSetters()
    {
        $route = new Route('class1', 'method1', ['a']);
        $route->setClass('class2');
        $route->setMethod('method2');
        $route->setParams(['b']);
        $this->assertEquals('class2', $route->getClass());
        $this->assertEquals('method2', $route->getMethod());
        $this->assertEquals(['b'], $route->getParams());
    }
}

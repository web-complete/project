<?php

namespace tests\unit\controller;

use Mvkasatkin\mocker\Mocker;
use tests\SomeController;
use tests\ThunderTestCase;
use WebComplete\thunder\controller\response\ResponseHtml;
use WebComplete\thunder\view\View;

class AbstractControllerTest extends ThunderTestCase
{

    public function testHtml()
    {
        /** @var View $view */
        $view = Mocker::create(View::class, [
            Mocker::method('layout', 1)->with(['someLayout'])->returnsSelf(),
            Mocker::method('render', 1)->with(['template1', ['a' => 'b']])->returns('some html')
        ]);
        $controller = new SomeController($view);
        $response = $controller->html('template1', ['a' => 'b']);
        $this->assertInstanceOf(ResponseHtml::class, $response);
    }

    public function testHtmlPartial()
    {
        /** @var View $view */
        $view = Mocker::create(View::class, [
            Mocker::method('layout', 1)->with([null])->returnsSelf(),
            Mocker::method('render', 1)->with(['template1', ['a' => 'b']])->returns('some html')
        ]);
        $controller = new SomeController($view);
        $response = $controller->html('template1', ['a' => 'b']);
        $this->assertInstanceOf(ResponseHtml::class, $response);
    }

    public function testJson()
    {

    }

    public function testRedirect()
    {

    }
}

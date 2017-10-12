<?php

namespace tests\unit\controller;

use Mvkasatkin\mocker\Mocker;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use tests\SomeController;
use tests\ThunderTestCase;
use WebComplete\mvc\view\View;

class AbstractControllerTest extends ThunderTestCase
{

    public function testHtml()
    {
        /** @var View $view */
        $view = Mocker::create(View::class, [
            Mocker::method('layout', 1)->with(['someLayout'])->returnsSelf(),
            Mocker::method('render', 1)->with(['template1', ['a' => 'b']])->returns('some html')
        ]);
        $request = new Request();
        $response = new Response();
        $controller = new SomeController($request, $response, $view);
        $response = Mocker::invoke($controller, 'responseHtml', ['template1', ['a' => 'b']]);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testHtmlPartial()
    {
        /** @var View $view */
        $view = Mocker::create(View::class, [
            Mocker::method('layout', 1)->with([null])->returnsSelf(),
            Mocker::method('render', 1)->with(['template1', ['a' => 'b']])->returns('some html')
        ]);
        $request = new Request();
        $response = new Response();
        $controller = new SomeController($request, $response, $view);
        $response = Mocker::invoke($controller, 'responseHtmlPartial', ['template1', ['a' => 'b']]);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testJson()
    {
        /** @var View $view */
        $view = Mocker::create(View::class);
        $request = new Request();
        $response = new Response();
        $controller = new SomeController($request, $response, $view);
        $response = Mocker::invoke($controller, 'responseJson', [['a' => 'b']]);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testRedirect()
    {
        /** @var View $view */
        $view = Mocker::create(View::class);
        $request = new Request();
        $response = new Response();
        $controller = new SomeController($request, $response, $view);
        $response = Mocker::invoke($controller, 'responseRedirect', ['aaa']);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testNotFound()
    {
        /** @var View $view */
        $view = Mocker::create(View::class);
        $request = new Request();
        $response = new Response();
        $controller = new SomeController($request, $response, $view);
        $response = Mocker::invoke($controller, 'responseNotFound');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testAccessDenied()
    {
        /** @var View $view */
        $view = Mocker::create(View::class);
        $request = new Request();
        $response = new Response();
        $controller = new SomeController($request, $response, $view);
        $response = Mocker::invoke($controller, 'responseAccessDenied');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(403, $response->getStatusCode());
    }
}

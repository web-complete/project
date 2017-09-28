<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . '/../../vendor/autoload.php';

defined('ENV') or define('ENV', in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], false) ? 'dev' : 'prod');
defined('DEV') or define('DEV', ENV === 'dev');
defined('PROD') or define('PROD', ENV === 'prod');

$request = Request::createFromGlobals();
$response = new Response();
$routes = (array)require '../../admin/config/routes.php';
$front = new \WebComplete\thunder\front\FrontController($request, $response);


(new \WebComplete\thunder\Application())->run();

$routes = (array)require '../../admin/config/routes.php';
$router = new \WebComplete\thunder\Router($routes);
try {
    $route = $router->dispatch($request->getMethod(), $request->getPathInfo());
}
catch (){}

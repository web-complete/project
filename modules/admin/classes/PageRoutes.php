<?php

namespace modules\admin\classes;

class PageRoutes
{

    protected $routes = [
        1000 => ['path' => '/', 'component' => 'VuePageMain'],
        1100 => ['path' => '*', 'component' => 'VuePage404'],
    ];

    /**
     * @return string
     */
    public function getRoutesJson(): string
    {
        $result = '[';
        $routes = $this->routes;
        \ksort($routes, \SORT_NUMERIC);
        foreach ($routes as $route) {
            $result .= '{';
            $result .= 'path: ' . \json_encode($route['path'], \JSON_UNESCAPED_SLASHES);
            $result .= ', component: ' . $route['component'];
            $result .= '},';
        }
        return \rtrim($result, ',') . ']';
    }

    /**
     * @param int $position
     * @param array $routeDefinition
     */
    public function addRoute(int $position, array $routeDefinition)
    {
        $this->routes[$position] = $routeDefinition;
    }
}

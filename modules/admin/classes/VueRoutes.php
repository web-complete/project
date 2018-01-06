<?php

namespace modules\admin\classes;

class VueRoutes
{

    protected $routes = [
        ['path' => '/detail/:entity/:id', 'component' => 'VuePageEntityDetail', 'sort' => 890],
        ['path' => '/list/:entity', 'component' => 'VuePageEntityList', 'sort' => 900],
        ['path' => '/', 'component' => 'VuePageMain', 'sort' => 1000],
        ['path' => '*', 'component' => 'VuePage404', 'sort' => 1100],
    ];

    /**
     * @return string
     */
    public function getRoutesJson(): string
    {
        $result = '[';
        $routes = $this->routes;
        \usort($routes, function (array $route1, array $route2) {
            return $route1['sort'] <=> $route2['sort'];
        });
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
        $routeDefinition['sort'] = $position;
        $this->routes[] = $routeDefinition;
    }
}

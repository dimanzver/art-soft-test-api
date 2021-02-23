<?php

// Для роутинга простенькая функция
function processRoute() {
    $requestPath = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $routes = require __DIR__ . '/../routes.php';

    foreach ($routes as $route => $action) {
        list($routeMethod, $routeAction) = explode(' ', $route);
        if($routeMethod !== $requestMethod || trim($routeAction, '/') !== trim($requestPath, '/'))
            continue;

        list($class, $method) = explode('::', $action);
        if(!method_exists($class, $method))
            continue;

        $content = (new $class)->$method();
        echo $content;
    }
}
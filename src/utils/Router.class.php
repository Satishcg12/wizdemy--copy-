<?php

/**
 * Router class
 */
class Router
{

    private $routes = [];
    public $middlewares = [];


    public function get($route, $callback, $middleware = null)
    {
        if ($middleware) {
            $this->middlewares['GET'][$route] = $middleware;
        }
        $this->routes['GET'][$route] = $callback;
    }
    public function post($route, $callback, $middleware = null)
    {
        if ($middleware) {
            $this->middlewares['POST'][$route] = $middleware;
        }
        $this->routes['POST'][$route] = $callback;
    }
    public function dispatch($method, $uri)
    {
        $method = strtoupper($method);
        if (!isset($this->routes[$method])) {
            throw new Exception('Method not allowed');
        }
        if (!isset($this->routes[$method][$uri])) {
            throw new Exception('Route not found', 404);

        }
        if (isset($this->middlewares[$method][$uri])) {
            $middleware = $this->middlewares[$method][$uri];
            $middleware = new $middleware();
            $middleware->handle();
        }
        $callback = $this->routes[$method][$uri];
        if (is_callable($callback)) {
            call_user_func($callback);
        } else {
            $this->callControllerMethod($callback);
        }
    }
    private function callControllerMethod($callback)
    {
        $callback = explode('@', $callback);
        $controller = $callback[0];
        $method = $callback[1];
        $controller = new $controller();
        $controller->$method();
    }
}
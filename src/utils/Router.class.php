<?php

/**
 * This class is responsible for routing 
 */
class Router
{

    private $routes = [];
    private $middlewares = [];

    public function get($route, $callback, $middleware = [])
    {
        if ($middleware) {
            $this->middlewares['GET'][$route] = $middleware;
        }
        $this->routes['GET'][$route] = $callback;
    }
    
    public function post($route, $callback, $middleware = [])
    {
        if ($middleware) {
            $this->middlewares['POST'][$route] = $middleware;
        }
        $this->routes['POST'][$route] = $callback;
    }
    
    /**
     * Dispatch the router
     * 
     * @param string $method
     * @param string $uri
     * @return void
     */
    public function dispatch($method, $uri)
    {
        $method = strtoupper($method);
        // if method is not allowed
        if (!isset($this->routes[$method])) {
            throw new Exception('Method not allowed');
        }
        // if route is not found
        if (!isset($this->routes[$method][$uri])) {
            throw new Exception('Route not found', 404);
        }
        // if middleware is set
        if (isset($this->middlewares[$method][$uri])) {
            $middlewares = $this->middlewares[$method][$uri];
            // if middleware is not an array, convert it to array
            if (!is_array($middlewares)) {
                $middlewares = [$middlewares];
            }
            // handle middleware one by one
            foreach ($middlewares as $middleware) {
                // if middleware class is not found
                if (!class_exists($middleware)) {
                    throw new Exception("Middleware class $middleware not found!");
                }
                // instantiate middleware class
                $middleware = new $middleware();
                // call the handle method of middleware class
                $middleware->handle($_REQUEST);
            }
            // call the controller method
            $this->callControllerMethod($this->routes[$method][$uri]);
        } else {
            // call the controller method
            $this->callControllerMethod($this->routes[$method][$uri]);
        }
    }
    
    /**
     * Call the controller method
     *
     * @param string $callback
     * @return void
     */
    private function callControllerMethod($callback)
    {
        if (!is_callable($callback)) {
            
            $callback = explode('@', $callback);
            $controller = $callback[0];
            $method = $callback[1];
            if (!class_exists($controller)) {
                throw new Exception("Controller class $controller not found!");
            }
            $controller = new $controller();
            if (!method_exists($controller, $method)) {
                throw new Exception("Method $method not found in $controller");
            }
            $controller->$method();
        } else {
            $callback();
        }
    }
}

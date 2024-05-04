<?php

/**
 * This class is responsible for routing 
 */
class Router
{

    private static $routes = [];
    private static $middlewares = [];

    public static function get($route, $callback, $middleware = [])
    {
        if ($middleware) {
            self::$middlewares['GET'][$route] = $middleware;
        }
        self::$routes['GET'][$route] = $callback;
    }
    
    public static function post($route, $callback, $middleware = [])
    {
        if ($middleware) {
            self::$middlewares['POST'][$route] = $middleware;
        }
        self::$routes['POST'][$route] = $callback;
    }
    
    /**
     * Dispatch the router
     * 
     * @param string $method
     * @param string $uri
     * @return void
     */
    public static function dispatch($method, $uri)
    {
        $method = strtoupper($method);
        // if method is not allowed
        if (!isset(self::$routes[$method])) {
            throw new Exception('Method not allowed');
        }
        // if route is not found
        if (!isset(self::$routes[$method][$uri])) {
            throw new Exception('Route not found', 404);
        }
        // if middleware is set
        if (isset(self::$middlewares[$method][$uri])) {
            $middlewares = self::$middlewares[$method][$uri];
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
            self::callControllerMethod(self::$routes[$method][$uri]);
        } else {
            // call the controller method
            self::callControllerMethod(self::$routes[$method][$uri]);
        }
    }
    
    /**
     * Call the controller method
     *
     * @param string $callback
     * @return void
     */
    private static function callControllerMethod($callback)
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
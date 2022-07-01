<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Route
 * YEAR: 2022
 */

namespace sFrameApp\Router;


//use sFrameApp\Exceptions\Whoops;

use sFrameApp\Http\Request;

class Route
{
    /**
     *
     * @var array $routes
     */
    private static array $routes = [];

    /**
     *
     * @var string $middleware
     */
    private static $middleware;

    /**
     *
     * @var string $parent
     */
    private static $parent;

    public function __construct()
    {
    }


    /**
     *
     * constructor
     */
    private function __constructor(): void{}

    /**
     *
     * @param string $methods
     * @param string $uri
     * @param object|callable $callback
     */
    private static function collector(string $methods, string $uri, $callback)
    {
        $uri = trim($uri, '/');
        $uri = rtrim(static::$parent . '/' . $uri, '/');
        $uri = $uri ?: '/';
        foreach ( explode('|', $methods) as $method ){
            static::$routes[] = [
                'uri' => $uri,
                'callback' => $callback,
                'method' => $method,
                'middleware' => static::$middleware
            ];
        }
    }

    /**
     *
     * @param string $uri
     * @param object|callable $callback
     */
    public static function get($uri, $callback)
    {
        static::collector('GET', $uri, $callback);
    }

    /**
     *
     * @param string $uri
     * @param object|callable $callback
     */
    public static function post($uri, $callback)
    {
        static::collector('POST', $uri, $callback);
    }

    /**
     *
     * @param string $uri
     * @param object|callable $callback
     */
    public static function any($uri, $callback): void
    {
        static::collector('GET|POST', $uri, $callback);
    }

    /**
     *
     * @return array
     */
    public static function allRoutes(): array
    {
        return static::$routes;
    }

    /**
     *
     * @param string $parent
     * @param callable $callback
     * @throws Exception
     */
    public static function parent(string $parent, callable $callback): void
    {
        $outer_parent = static::$parent;
        static::$parent .= '/' . trim($parent, '/');
        if ( is_callable($callback) ){
            call_user_func($callback);
        } else {
            throw new \BadFunctionCallException("Please provide callback function");
        }

        static::$parent = $outer_parent;
     }

    /**
     *
     * @param string $middleware
     * @param callable $callback
     * @throws Exception
     */
    public static function middleware(string $middleware, callable $callback): void
    {
        $outer_middleware = static::$middleware;
        static::$middleware .= '|' . trim($middleware, '|');
        if ( is_callable($callback) ){
            call_user_func($callback);
        } else {
            throw new \BadFunctionCallException("Please provide callback function");
        }

        static::$middleware = $outer_middleware;
    }

    /**
     *
     *
     * @return mixed
     *
     */
    public static function routeHandler(): mixed
    {
        $uri = Request::urlPath();

        foreach (static::$routes as $route){
            $matched = true;
            $route['uri'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['uri']);
            $route['uri'] = '#^' . $route['uri'] . '$#';
            if ( preg_match($route['uri'], $uri, $matches) ){
                array_shift($matches);

                $parameters = array_values($matches);

                foreach($parameters as $par){
                    if (strpos($par, '/')){
                        $matched = false;
                    }
                }

                if ($route['method'] != Request::urlMethod()){
                    $matched = false;
                }

                if ($matched == true){
                   return static::invokeRoute($route, $parameters);
                }
            }
        }
        die("Not found");

//        return false;
    }


    /**
     * trying to access the callback function of provided route
     *
     * @param array $route
     * @param array $params
     */
    public static function invokeRoute(array $route, array $params)
    {
        static::runMiddleware($route);

        $callback = $route['callback'];

        if (is_callable($callback)){
            return call_user_func_array($callback, $params);
        } elseif ( strpos($callback, '@') !== false ) {
            list($controller, $method) = explode('@', $callback);
            // load the controller by namespace
            $controller = 'app\Controllers\\' . $controller;
            if (class_exists($controller)){
                $controllerObject = new $controller;

                if (method_exists($controllerObject, $method)){
                    return call_user_func_array([$controllerObject, $method], $params);
                }else {
                    throw new \BadFunctionCallException("The method ". $method . " does not exist in the controller ". $controller);
                }

            } else {
                throw new \ReflectionException("Controller ". $controller ." does not exist");
            }
        }else{
            throw new \InvalidArgumentException("Please provide a valid and accessible callback function");
        }


    }


    /**
     *
     * @param array $route
     */
    public static function runMiddleware(array $route)
    {
        foreach ( explode('|', $route['middleware']) as $singleMiddleware ){
            // check if not empty
            if ($singleMiddleware != ''){
                $singleMiddleware = 'app\Middleware\\' . $singleMiddleware;

                if (class_exists($singleMiddleware)){
                    $middlewareObject = new $singleMiddleware;
                    call_user_func_array([$middlewareObject, 'handle'], []);
                } else {
                    throw new \ReflectionException("Middleware ". $singleMiddleware ." does not exist");
                }

            }
        }
    }



}
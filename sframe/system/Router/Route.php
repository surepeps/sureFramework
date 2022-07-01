<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Route
 * YEAR: 2022
 */

namespace sFrameApp\Router;


class Route
{
    /**
     *
     * @var array $routes
     */
    private static $routes = [];

    /**
     *
     * @var string $middleware
     */
    private static $middleware;

    /**
     *
     * @var string $prefix
     */
    private static $prefix;


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
        $uri = rtrim(static::$prefix . '/' . trim($uri . '/'), '/');
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
    public static function any($uri, $callback)
    {
        static::collector('GET|POST', $uri, $callback);
    }

    /**
     *
     * @return array
     */
    public static function allRoutes()
    {
        return static::$routes;
    }

}
<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Server
 * YEAR: 2022
 */

namespace sFrameApp\Http;

class Server
{
    /**
     * constructor
     */
    private function __construct() {}

    /**
     * Check if server has the key
     *
     * @param string $key
     * @return boolean
     */
    public static function has(string $key): bool
    {
        return isset($_SERVER[$key]);
    }

    /**
     * get server value by key
     *
     * @param string @key
     * @return mixed
     */
    public static function getValue($key)
    {
        if (Static::has($key)){
            return $_SERVER[$key];
        }
        return null;
    }

    /**
     * get all server data
     *
     * @return array
     */
    public static function all(): array
    {
        return $_SERVER;
    }

    /**
     * get path information
     *
     * @param string $path
     * @return array
     */
    public static function PathInfo($path): array
    {
        return pathinfo($path);
    }

}
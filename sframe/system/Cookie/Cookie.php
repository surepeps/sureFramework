<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Cookie
 * YEAR: 2022
 */

namespace sFrameApp\Cookie;

class Cookie
{
    /**
     *
     * constructor
     *
     */
    private function __constructor() {}


    /**
     * Set new cookie
     *
     * @param string $key
     * @param string $value
     *
     * @return string $value
     */
    public static function set(string $key, string $value): string
    {
        $expired = time() + (1 * 365 * 24 * 60 * 60);
        setcookie($key, $value, $expired, '/', '', false, true);
        return $value;
    }

    /**
     * Confirm cookie key
     *
     * @param string $key
     * @return boolean
     *
     */
    public static function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Get cookie by a specific key
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        return static::has($key) ? $_COOKIE[$key] : null;
    }

    /**
     * Remove cookie
     *
     * @param string $key
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_COOKIE[$key]);
        setcookie($key, null , -1, '/');
    }

    /**
     * Get all cookie at once
     *
     * @return array
     */
    public static function getAll(): array
    {
        return $_COOKIE;
    }

    /**
     * Destroy the cookie
     *
     * @return void
     */
    public static function destroy(): void
    {
        foreach (static::getAll() as $key => $value){
            static::remove($key);
        }
    }

}


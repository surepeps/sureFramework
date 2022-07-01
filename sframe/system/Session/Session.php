<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Session
 * YEAR: 2022
 */

namespace sFrameApp\Session;

class Session
{
    /**
     *
     * constructor
     *
     */
    private function __constructor() {}

    /**
     *
     * Start session
     * 
     * @return void
     *
     */
    public static function start(): void
    {
        if (!session_id()){
            ini_set('session.use_only_cookies', 1);
            session_start();
        }
    }

    /**
     * Set new session
     *
     * @param string $key
     * @param string $value
     *
     * @return string $value
     */
    public static function set(string $key, string $value): string
    {
        $_SESSION[$key] = $value;
        return $value;
    }

    /**
     * Confirm session key
     *
     * @param string $key
     * @return boolean
     *
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get session by a specific key
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        return static::has($key) ? $_SESSION[$key] : null;
    }

    /**
     * Remove session
     *
     * @param string $key
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Get all session at once
     *
     * @return array
     */
    public static function getAll(): array
    {
        return $_SESSION;
    }

    /**
     * Destroy the session
     *
     * @return void
     */
    public static function destroy(): void
    {
        foreach (static::getAll() as $key => $value){
            static::remove($key);
        }
    }

    /**
     * get session flasher
     *
     * @param string key
     * @return string $value
     */
    public static function flashSession($key)
    {
        $value = null;
        if (static::has($key)){
            $value = static::get($key);
            static::remove($key);
        }
        return $value;
    }
}


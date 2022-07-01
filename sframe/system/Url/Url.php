<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Url.php
 * YEAR: 2022
 */


namespace sFrameApp\Url;

use sFrameApp\Http\Request;
use sFrameApp\Http\Server;

class Url
{
    /**
     *
     * constructor
     */
    private function __construct() {}

    /**
     * Get path
     * @param string $urlPath
     * @return string $urlPath
     */
    public static function path(string $urlPath)
    {
        return Request::baseUrl() . '/' . trim($urlPath, '/');
    }

    /**
     * Get previous Url
     *
     * @return string
     */
    public static function previousUrl()
    {
        return Server::getValue('HTTP_REFERER');
    }

    /**
     * Redirector / Redirect 
     *
     * @param string $urlPath
     * @return void
     */
    public static function redirector(string $urlPath)
    {
        header("Location: ". $urlPath);
        exit();
    }
}
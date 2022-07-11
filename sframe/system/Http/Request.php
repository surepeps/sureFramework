<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Request.php
 * YEAR: 2022
 */


namespace sFrameApp\Http;

class Request
{
    /**
     * Base Url Declaration
     *
     * @var string $base_Url
     */
    private static $base_Url;

    /**
     * Script name Declaration
     *
     * @var string $script_name
     */
    private static $script_name;

    /**
     * URL Declaration
     *
     * @var $url
     */
    private static $url;

    /**
     * Complete URL Declaration
     *
     * @var $cUrl
     */
    private static $cUrl;

    /**
     * Query Declaration
     *
     * @var $uQuery
     */
    private static $uQuery;


    /**
     * constructor
     *
     * @return void
     */
    private function __construct() {}

    /**
     * Request collector
     *
     * @return void
     */
    public static function collector()
    {
        static::$script_name = str_replace('\\', '', dirname(Server::getValue('SCRIPT_NAME')));
        static::setBaseUrl();
        static::setUrl();
    }

    /**
     * @return void
     *
     */
    private static function setBaseUrl()
    {
        $protocol = Server::getValue('REQUEST_SCHEME') .'://';
        $host = Server::getValue('HTTP_HOST');
        $scriptName = static::$script_name;

        static::$base_Url = $protocol. $host . $scriptName;

    }

    /**
     * @return void
     *
     */
    private static function setUrl()
    {
        $request_url = urldecode(Server::getValue('REQUEST_URI'));
        $request_url = rtrim(preg_replace("#^". static::$script_name. '#', '', $request_url), '/');

        $query_string = '';
        static::$cUrl = $request_url;
        if (strpos($request_url, '?')){
            list($request_url, $query_string) = explode('?', $request_url);
        }

        static::$url = $request_url ?: '/';
        static::$uQuery = $query_string;
    }

    /**
     * @return string
     *
     */
    public static function baseUrl()
    {
        return static::$base_Url;
    }

    /**
     * @return string
     *
     */
    public static function urlPath()
    {
        return static::$url;
    }

    /**
     * @return string
     *
     */
    public static function urlQuery()
    {
        return static::$uQuery;
    }

    /**
     * @return string
     *
     */
    public static function urlQueryPath()
    {
        return static::$cUrl;
    }

    /**
     * @return string
     */
    public static function urlMethod()
    {
        return Server::getValue('REQUEST_METHOD');
    }

    /**
     *
     * @param string $key
     * @return string
     */
    public static function get(string $key)
    {
        return static::value($key, $_GET);
    }

    /**
     *
     * @param array $type
     * @param string $key
     * @return boolean
     */
    public static function has(array $type, string $key)
    {
        return array_key_exists($key, $type);
    }

    /**
     *
     * @param string $key
     * @param array|null $type
     * @return bool|null
     */
    public static function value(string $key, array $type = null)
    {
        $type = $type ?? $_REQUEST;
        return static::has($type, $key) ? $type[$key] : null;
    }

    /**
     *
     * @param string $key
     * @return string
     */
    public static function post(string $key)
    {
        return static::value($key, $_POST);
    }

    /**
     *
     * @param string $key
     * @param string $value
     * @return string $value
     */
    public static function set(string $key, string $value)
    {
        $_REQUEST[$key] = $value;
        $_POST[$key] = $value;
        $_GET[$key] = $value;

        return $value;
    }

    /**
     *
     * @return string
     */
    public static function previous()
    {
        return Server::getValue('HTTP_REFERER');
    }


    /**
     *
     * @return array
     */
    public static function all()
    {
        return $_REQUEST;
    }
}
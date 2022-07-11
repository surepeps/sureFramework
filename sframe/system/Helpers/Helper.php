<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Helper
 * YEAR: 2022
 */

/**
 * View Rendering Helper
 *
 * @param string $path
 * @param array $data
 *
 * @return mixed
 */
if (! function_exists('view')){
    function view($path, $data = [])
    {
        return sFrameApp\View\View::render($path, $data);
    }
}

/**
 * Redirect Helper
 *
 * @param string $key
 *
 * @return void
 */
if (! function_exists('redirect')){
    function redirect($path)
    {
        return sFrameApp\Url\Url::redirector($path);
    }
}

/**
 * Previous Helper
 *
 * @return string
 */
if (! function_exists('previousUrl')){
    function previousUrl()
    {
        return sFrameApp\Url\Url::previousUrl();
    }
}

/**
 * URL Path Helper
 *
 * @param string $path
 *
 * @return string
 */
if (! function_exists('urlPath')){
    function urlPath($path)
    {
        return sFrameApp\Url\Url::path($path);
    }
}

/**
 * Asset Path Helper
 *
 * @param string $path
 *
 * @return string
 */
if (! function_exists('asset')){
    function asset($path)
    {
        return sFrameApp\Url\Url::path($path);
    }
}

/**
 * Dump and Die Helper
 *
 * @param string $data
 *
 * @return string
 */
if (! function_exists('dd')){
    function dd($data)
    {
        echo "<pre>";
        if (is_string($data)) {
            echo $data;
        } else {
            print_r($data);
        }
        echo "</pre>";
        exit;
    }
}


/**
 * DOTENV Helper
 *
 * @param string $data
 *
 * @return string
 */
if (! function_exists('collectEnv')){
    function collectEnv($data)
    {
       $endloader =  \Dotenv\Dotenv::createImmutable(\sFrameApp\FileHandling\Filehandling::mainRoot());
       $endloader->load();

       $endVal = $_ENV[$data];

        return $endVal;
    }
}

/**
 * Required DOTENV Helper
 *
 * @return string
 */
if (! function_exists('requiredEnv')){
    function requiredEnv()
    {
        $endloader =  \Dotenv\Dotenv::createImmutable(\sFrameApp\FileHandling\Filehandling::mainRoot());
        $endloader->load();

        $endloader->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

    }
}
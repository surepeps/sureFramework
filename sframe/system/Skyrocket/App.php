<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: App
 * YEAR: 2022
 */

namespace sFrameApp\Skyrocket;


use sFrameApp\Exceptions\Whoops;
use sFrameApp\FileHandling\Filehandling;
use sFrameApp\Http\Request;
use sFrameApp\Http\Response;
use sFrameApp\Router\Route;
use sFrameApp\Session\Session;

class App
{
    /**
     * Constructor
     *
     * @return void
     */
    private function __construct(){}

    /**
     * Start the application
     *
     * @return void
     */
    public static function starter(){
        /**
         * Initialization of Exception
         */
        Whoops::handler();

        /**
         * Session starter
         */
        Session::start();

        /**
         * Handling URL Request
         */
        Request::collector();

        /**
         * Handling Routes Request (Web/Api/Route)
         */
        Filehandling::require_directory('routes');

        /**
         * Routing Handler
         */
        $routHandler = Route::routeHandler();



//        echo "<pre>";
//        print_r(Route::routeHandler());
//        echo "</pre>";
//        exit;
        echo Response::outputData($routHandler);
    }



}
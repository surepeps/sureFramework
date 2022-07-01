<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Application
 * YEAR: 2022
 */

use sFrameApp\Skyrocket\App;

class Application
{

    /**
     *
     * Constructor
     *
     */

    private function __constructor(){ }

    /**
     *
     * Starter method
     *
     * @return void
     * @throws Exception
     */
    public static function starter()
    {
        /**
         *
         * Root path
         *
         */
        define('ROOT', realpath(__DIR__.'/..'));

        /**
         *
         * Directory separator
         *
         */
        define('DS', DIRECTORY_SEPARATOR);

        /**
         *
         * Start the application
         *
         */
        App::starter();
    }
}
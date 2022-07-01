<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Whoops.php
 * YEAR: 2022
 */

namespace sFrameApp\Exceptions;

class Whoops {

    /**
     *
     * constructor
     */
    private function __constructor() {}

    /**
     *
     * Whoops exception
     *
     * @return void
     *
     */
    public static function handler() {
        $whoops = new \Whoops\Run;
        $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }


}

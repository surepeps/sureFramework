<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Response
 * YEAR: 2022
 */


namespace sFrameApp\Http;

class Response
{
    /**
     *
     * constructor
     */
    private function __constructor() {}

    /**
     * Outputing controller method data
     * 
     * @param mixed $data
     */
    public static function outputData($data)
    {
        if (!$data) { return ; }
        if ( !is_string($data) ){
            $data = static::json($data);
        }
        echo $data;
    }

    /**
     *
     *
     * @param string $data
     */
    public static function json($data)
    {
        return json_encode($data);
    }
}
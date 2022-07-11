<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Validator
 * YEAR: 2022
 */


namespace sFrameApp\Validation;

use Rakit\Validation\Validator;
use sFrameApp\Http\Request;
use sFrameApp\Session\Session;
use sFrameApp\Url\Url;

class Validation
{
    /**
     *
     * constructor
     */
    private function __construct() {}

    /**
     * Validate request
     *
     * @param array $rules
     * @param bool $json
     *
     * @return mixed
     */
    public static function validate(array $rules, bool $json)
    {
        $validator = new Validator;

        $validation = $validator->make($_POST + $_FILES, $rules);

        $errors = $validation->errors();

        if ($validation->fails()) {
            if ($json){
                return ['errors' => $errors->firstOfAll()];
            } else {
                Session::set('errors', $errors);
                Session::set('old', Request::all());
                return Url::redirector(Url::previousUrl());
            }
        }

    }

}
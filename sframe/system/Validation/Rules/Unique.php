<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Unique
 * YEAR: 2022
 */


namespace sFrameApp\Validation\Rules;

use Rakit\Validation\Rule;
use sFrameApp\Database\Database;

class Unique extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];


    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except and $except == $value) {
            return true;
        }

        // do query
        $data = Database::table($table)->where($column, '=', $value)->first();

        // true for valid, false for invalid
        return $data ? false : true;
    }
}

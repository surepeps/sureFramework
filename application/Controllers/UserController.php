<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: UserController
 * YEAR: 2022
 */


namespace app\Controllers;

use app\Models\User;
use sFrameApp\FileHandling\Filehandling;

class UserController
{
    /**
     *
     */
    public function index()
    {
//        $Dbdata = ["name" => "Munna 233", "email" => "muna@me.com", "username" => "muna"];
//        return Database::table('user')->where('user_id', '=', 3)->delete();
//         return dd(['name' => "Hassan", 'email' => "me@me.com"]);
//        $dataB = Database::query("SELECT * FROM `user` WHERE id = 1")->get();
//        return Database::query('SELECT * FROM user RIGHT JOIN comp ON comp.id = user.id LEFT JOIN dataT t ON t.id = comp.id')->getQuery();
        $data =  User::paginator(1);
//        return Filehandling::fileChecker('.env');
        $databaseData = Filehandling::require_file('config/config.php');
        extract($databaseData);
        $arrayData = [
            'dd' => $data,
            'other' => $DATABASE['my_host ']
        ];

        print_r($arrayData);
        exit;
//        $vart = $_REQUEST;
//        print_r($_REQUEST);
//        return Database::instance();
        return view('admin.home', ['data' => $arrayData]);
//        return ROOT;

    }
}
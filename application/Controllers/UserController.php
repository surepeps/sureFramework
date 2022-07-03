<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: UserController.php
 * YEAR: 2022
 */


namespace app\Controllers;

use sFrameApp\Database\Database;
use sFrameApp\View\View;

class UserController
{
    /**
     *
     */
    public function index()
    {
//         return Filehandling::filePath('config/database.php');
//        $dataB = Database::query("SELECT * FROM `user` WHERE id = 1")->get();
//        return Database::query('user');
        return Database::table('user')->select('name','username')->getQuery();
//        return Database::instance();
        return View::render('admin.home', ['name' => 'Hassan', 'username' => 'Surecoder']);

    }
}
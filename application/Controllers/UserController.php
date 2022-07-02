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
use sFrameApp\FileHandling\Filehandling;

class UserController
{
    public function index()
    {
//         return Filehandling::filePath('config/database.php');
        return Database::instance();
//        $names = ['name' => 'Hassan', 'username' => 'Surecoder', 'age' => Filehandling::filePath('config/database.php')];
//        return View::render('admin.home', $names);

    }
}
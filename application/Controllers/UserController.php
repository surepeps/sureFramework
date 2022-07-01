<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: UserController.php
 * YEAR: 2022
 */


namespace app\Controllers;

use sFrameApp\View\View;

class UserController
{
    public function index()
    {
        $names = ['name' => 'Hassan', 'username' => 'Surecoder', 'age' => 44];
        return View::render('admin.home', $names);

    }
}
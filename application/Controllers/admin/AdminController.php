<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: AdminController.php
 * YEAR: 2022
 */


namespace app\Controllers\admin;

class AdminController
{


    public function index()
    {
        return view('hello', []);
    }
}
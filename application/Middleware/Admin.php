<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Admin.php
 * YEAR: 2022
 */


namespace app\Middleware;

class Admin
{
    public function handle()
    {
        if(1 == 1){
            die("Error in Admin Middleware");
        }
    }
}
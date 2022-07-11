<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Web Route
 * YEAR: 2022
 */

use sFrameApp\Router\Route;

/**
 *
 * Web Routes
 */

Route::get('/users/{id}/edit', function (){
    echo "test edit page";
});

//Route::get('/{id}/edit', function (){
//    echo "test edit page";
//});

Route::get('/home', function (){
    echo "<a href='http://localhost/sureframe/public/user' >Click Here to go back</a>";
});

Route::get('', 'admin\AdminController@index');

Route::get('/user', 'UserController@index');

Route::parent('/admin', function (){

    Route::middleware('Admin|Owner', function (){
        Route::get('/user', 'UserController@index');
        Route::get('/dashboard', 'DashboardController@index');
    });


    Route::parent('/owner', function (){
        Route::get('/user', 'UserController@index');
        Route::get('/dashboard', 'DashboardController@index');
    });

});



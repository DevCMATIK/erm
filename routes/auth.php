<?php

Route::namespace('Auth\Controllers')->group(function () {

    Route::middleware('visitor')->group(function () {
        /*Login Route*/
        Route::view('login','auth.pages.login')->name('main.login');
        Route::post('login','LoginController@postLogin');
        /* Register Route*/
        Route::view('register','auth.pages.register')->name('main.register');
        Route::post('register','RegisterController');
        /* Forgot Password Route */
        Route::view('forgot-password','auth.pages.forgot-password')->name('main.forgot-password');
        Route::post('forgot-password','ForgotPasswordController');
        /* Reset Password*/
        Route::get('reset/{email}/{code}', 'ResetPasswordController@index');
        Route::post('reset/{email}/{code}','ResetPasswordController@postResetPassword');

    });

    Route::middleware('auth')->group(function(){
        /* Logout */
        Route::get('logout','LoginController@logout');
    });


});




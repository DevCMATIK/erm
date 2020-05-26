<?php
Route::group(['middleware' => 'auth'], function() {
    Route::get('importFileProcess/{modul}/{id}',function($modul,$id){
        $controller = app()->make('App\Http\Imports\Controllers\Import'. studly_case($modul)."Controller" );
        return $controller->callAction('processData', ['id'=>$id]);
    });
});

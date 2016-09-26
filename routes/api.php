<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::group(['namespace' => 'API'], function() {

    Route::resource('goods-received', 'GoodsReceivedController');

    Route::post('element/search', 'ElementController@search');
    Route::post('element/attach-file', 'ElementController@attachFile');
    Route::post('element/detach-file', 'ElementController@detachFile');
    Route::post('element/attach-task', 'ElementController@attachTask');
    Route::post('element/detach-task', 'ElementController@detachTask');
    Route::post('element/export', 'ElementController@postExport');
    Route::post('element/replicate', 'ElementController@replicate');
    Route::get('element/export/{hash}/{type}', 'ElementController@getExport');
    Route::resource('element', 'ElementController');

    Route::resource('element-task', 'ElementTaskController');

    Route::resource('company', 'CompanyController');

    Route::post('file/search', 'FileController@search');
    Route::resource('file', 'FileController');

    Route::resource('project', 'ProjectController');
});
<?php
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web']], function () {
Route::group(['namespace' => 'Leadingdots\CustomEmail\Http\Controllers','prefix' => config('coderepoldots.prefix'), 'middleware' => [config('coderepoldots.middleware')],'as'=>'ldots.'], function(){
   
    //token routes
    Route::resource('token', 'TokensController');
    Route::post('/token/status', 'TokensController@status')->name('token.status');
    Route::get('token-list', 'TokensController@listTokens')->name('token.list');
    Route::delete('/delete-token', 'TokensController@delete')->name('token.delete');

    //template routes
    Route::resource('template', 'TemplatesController');
    Route::post('/template/status', 'TemplatesController@status')->name('template.status');
    Route::get('template-list', 'TemplatesController@listTemplates')->name('template.list');
    Route::delete('/delete-template', 'TemplatesController@delete')->name('template.delete');
});
});
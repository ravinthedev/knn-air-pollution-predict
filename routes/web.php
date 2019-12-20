<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/data/feed', 'PredictionController@getData')->name('getData');

Route::get('/test', 'PredictionController@predict')->name('predict');
Route::get('/predict/more', 'PredictionController@predictMore')->name('predictMore');

Route::get('/prepare/data', 'PredictionController@prepare')->name('prepare');

Route::get('/chart/generate', 'PredictionController@chart')->name('chart');
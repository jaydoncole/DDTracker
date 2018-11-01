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

Route::get('/dungeonRun', 'DungeonRunController@StartRun')->name('dungeonRun');
Route::post('/saveDungeonRun', 'DungeonRunController@SaveRun')->name('saveDungeonRun');

Route::get('/statistics', 'StatisticsController@Index')->name('statistics');

Route::get('gameInformation', 'GameInformationController@Index')->name('gameInformation');


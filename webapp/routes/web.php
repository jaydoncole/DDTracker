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
$router->get( 'api/locations',                                'ApiController@getLocations');
$router->get( 'api/difficultyLevels',                         'ApiController@getDifficultyLevels');
$router->get( 'api/locationLengths',                          'ApiController@getLocationLengths');
$router->get( 'api/characters',                               'ApiController@getCharacters');
$router->get( 'api/provisions',                               'ApiController@getProvisions');
$router->get( 'api/characterSuggestions/{slot}/{location}',   'ApiController@getCharacterSelection');
$router->get( 'api/provisionSuggestions/{location}/{length}', 'ApiController@getProvisionRecommendations');
$router->post('api/saveRun',                                  'ApiController@saveRun');


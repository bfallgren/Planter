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
    // Test database connection
    try {
        DB::connection()->getPdo();
        echo "Connected successfully to Database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        //die("Could not connect to the database. Please check your configuration. error:" . $e );
        echo("Could not connect to MySQL database. Please check your configuration. Database:" . DB::connection()->getDatabaseName());
    }
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});


/* App Resources */
Route::resource('areas', 'AreaController');
Route::resource('links', 'LinkController');
Route::resource('items', 'ItemController');
Route::resource('events', 'EventController');
Route::resource('needs', 'NeedController');
Route::resource('tasks', 'TaskController');
Route::resource('props', 'PropController');

 /* THE FOLLOWING ARE USED FOR ALIAS IN APPS.BLADE.PHP */
 Route::get('/areas', 'AreaController@index')->name('areas');
 Route::get('/links', 'LinkController@index')->name('links');
 Route::get('/items', 'ItemController@index')->name('items');
 Route::get('/needs', 'NeedController@index')->name('needs');
 Route::get('/events', 'EventController@index')->name('events');
 Route::get('/tasks', 'TaskController@index')->name('tasks');
 Route::get('/props', 'PropController@index')->name('props');
 Route::get('items/{item}', ['as' => 'items.index', 'uses' => 'ItemController@index']);
 Route::get('needs/{need}', ['as' => 'needs.index', 'uses' => 'NeedController@index']);
 Route::get('props/{prop}', ['as' => 'props.index', 'uses' => 'PropController@index']);

// Route for get areas for yajra post request (ajax)
Route::get('/get-areas', 'AreaController@getAreas')->name('get-areas');
Route::get('/get-links', 'LinkController@getLinks')->name('get-links');

// Route for calendar view 
Route::get('/showCal', 'EventController@show')->name('showCal');



Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', function () {
    return view('welcome');
});

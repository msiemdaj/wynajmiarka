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
    return view('pages/index');
});

Auth::routes(['verify' => true]);

Route::get('ogloszenia/dodaj', ['middleware' => 'auth', 'uses' => 'OgloszeniaController@create'])->name('ogloszenia.create');
Route::resource('ogloszenia', 'OgloszeniaController')->except([
    'create'
]);

Route::get('/ogloszenia/{id}/showcontact', ['middleware' => 'auth', 'uses' => 'OgloszeniaController@showContact']);
Route::get('/ustawienia', 'UstawieniaController@index')->name('ustawienia');
Route::get('/twojeogloszenia', 'OgloszeniaController@twojeogloszenia')->name('twojeogloszenia');

Route::any('/search', 'OgloszeniaController@search');

Route::put('/ustawienia/sec', 'UstawieniaController@security');
Route::put('/ustawienia/con', 'UstawieniaController@contact');
Route::put('/ustawienia/deactivate', 'UstawieniaController@deactivate');
Route::put('/ustawienia/notifi', 'UstawieniaController@changeNotification');
Route::post('ogloszenia/{id}/sendmessage', 'MessagesController@sendMessage');
Route::get('/wiadomosci', 'MessagesController@index')->name('skrzynka');
Route::get('/wiadomosci/deletechecked', 'MessagesController@deleteChecked');
Route::get('/wiadomosci/skrzynkaoptions', 'MessagesController@skrzynkaOptions');
Route::get('/wiadomosci/{id}', 'MessagesController@show');
Route::get('/wiadomosci/{id}/delete', 'MessagesController@deleteMessage')->name('del');
Route::post('/wiadomosci/{id}/reply', 'MessagesController@replyMessage');
Route::get('/wiadomosci/{id}/viewed', 'MessagesController@markAsNotViewed');

Route::get('/wiadomosci/{id}/changeviewedstatus', 'MessagesController@changeViewedStatus');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('ogloszenia/{id}/addtofav', 'OgloszeniaController@addToFavourite');

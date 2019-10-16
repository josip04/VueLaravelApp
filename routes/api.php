<?php

use Illuminate\Http\Request;
use App\Proizvodi;
use App\Kategorija;
use App\Narudzba;
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

//za testiranje access tokena 
/* Route::middleware('auth:api')->get('/user',function(Request $request){
    return $request->user();
})->name('user'); */

//test za kreiranje novog restorana, slika je pretvorena u base64 string
/* Route::post('/restoraniSlika',function(Request $request){
    return response()->json($request);
})->name('restoraniSlika'); */







/* rute koje su isključene iz auth middlewarea */

Route::get('/', function () {
    return view('index');
})->name('/');
Route::post('/prijava', 'AuthController@prijava')->name('prijava'); 
Route::post('/registracija', 'AuthController@registracija')->name('registracija');
Route::get('/restorani', 'RestoranController@index')->name('restorani.index');
Route::get('/restorani/{id}', 'RestoranController@show')->name('restorani.show');
Route::get('restorani/{id}/komentari', 'KomentariController@index')->name('komentari.index');
Route::get('/kategorije/{id}', 'KategorijeController@show')->name('kategorije.show');
//Route::get('/proizvodi', 'ProizvodiController@index')->name('proizvodi.index');
//proširenje ProizvodiControllera
Route::get('/proizvodi/restoran/{id}',function($restoran_id){
    $proizvodi = Proizvodi::where('restoran_id',$restoran_id)->get();
    return response()->json($proizvodi);
});
Route::get('/proizvodi/{id}', 'ProizvodiController@show')->name('proizvodi.show');
/* kraj */



 /* middleware => auth:api */

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('restorani', 'RestoranController')->except(['index','show']); 
    Route::resource('restorani.komentari', 'KomentariController')->except(['index']); 
    Route::resource('/kategorije','KategorijeController')->except(['show']); 
    Route::resource('/proizvodi','ProizvodiController')->except(['index','show']);
    Route::resource('/narudzbe','NarudzbeController');
});

/* kraj */


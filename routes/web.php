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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/home/{returnType?}', function($returnType = 'view'){
    $homeController = app()->make('\App\Http\Controllers\HomeController');
    return $homeController->index($returnType);
})->middleware('auth')->name('home');

Route::get('/home/ultimosInvestimentos/{returnType?}', function($returnType = 'view'){
    $homeController = app()->make('\App\Http\Controllers\HomeController');
    if($returnType == 'view')
        return $homeController->index($returnType);
    else
        return $homeController->getCincoUltimosInvestimentos();
})->middleware('auth')->name('home');

Route::get('/home/getSaldo/{returnType?}', function($returnType = 'view'){
    $homeController = app()->make('\App\Http\Controllers\HomeController');
    if($returnType == 'view')
        return $homeController->index($returnType);
    else
        return $homeController->getSaldo();
})->middleware('auth')->name('home');

Route::get('/investimentos', function(){

    $homeController = app()->make('\App\Http\Controllers\InvestimentosController');
    return $homeController->index();

})->middleware('auth')->name('investimentos');

Route::post('/investimentos/save', function(Illuminate\Http\Request $request){
    $investimentosController = app()->make('\App\Http\Controllers\InvestimentosController');
    return $investimentosController->store($request);

})->middleware('auth')->name('save-investimento');


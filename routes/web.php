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
    if(Auth::check()){
        $homeController = app()->make('\App\Http\Controllers\HomeController');
        return $homeController->index();
    }else{
        return view('auth.home');
    }
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
    if ($returnType == 'view')
        return $homeController->index($returnType);
    else
        return $homeController->getSaldo();

})->middleware('auth')->name('home');

Route::get('/home/getLucro/{returnType?}', function($returnType = 'view'){
    $homeController = app()->make('\App\Http\Controllers\HomeController');
    if ($returnType == 'view')
        return $homeController->index($returnType);
    else
        return $homeController->getLucro();

})->middleware('auth')->name('home');

Route::get('/investimentos', function(){

    $homeController = app()->make('\App\Http\Controllers\InvestimentosController');
    return $homeController->index();

})->middleware('auth')->name('investimentos');

Route::post('/investimentos/save', function(Illuminate\Http\Request $request){
    $investimentosController = app()->make('\App\Http\Controllers\InvestimentosController');
    return $investimentosController->store($request);

})->middleware('auth')->name('save-investimento');

Route::get('/contas', function(){

    $contasController = app()->make('\App\Http\Controllers\ContasController');
    return $contasController->index();

})->middleware('auth')->name('contas');


Route::view('/contas/extrato', 'contas.extrato')->middleware('auth')->name('extrato-contas');

Route::post('/contas/transacao/save', function(Illuminate\Http\Request $request){
    $contasController = app()->make('\App\Http\Controllers\ContasController');
    return $contasController->storeTransacao($request);
})->middleware('auth')->name('contas-save-transacao');

Route::get('/contas/getContas/{returnType?}', function($returnType = 'view'){
    $contasController = app()->make('\App\Http\Controllers\ContasController');
    if ($returnType == 'view')
        return $contasController->index($returnType);
    else
        return $contasController->getContas();

})->middleware('auth')->name('home');

Route::get('/contas/getDadosContas/{returnType?}', function($returnType = 'view'){
    $contasController = app()->make('\App\Http\Controllers\ContasController');
    if ($returnType == 'view')
        return $contasController->index($returnType);
    else
        return $contasController->getDadosContas();

})->middleware('auth')->name('home');

Route::get('/investimentos/tabela/{returnType?}', function($returnType = 'view'){
    $investimentosController = app()->make('\App\Http\Controllers\InvestimentosController');
    if($returnType == 'view')
        return $investimentosController->index($returnType);
    else
        return $investimentosController->getInvestimentosTabela();
})->middleware('auth')->name('home-table');

Route::get('/chart/dashboard/{returnType?}', function($returnType = 'view'){
    $homeController = app()->make('\App\Http\Controllers\HomeController');
    if($returnType == 'view')
        return $homeController->index($returnType);
    else
        return $homeController->getChartData();
})->middleware('auth')->name('chart-dashboard');

Route::get('/chart/dashboard/dia/{returnType?}', function($returnType = 'view'){
    $homeController = app()->make('\App\Http\Controllers\HomeController');
    if($returnType == 'view')
        return $homeController->index($returnType);
    else
        return $homeController->getChartDataHora();
})->middleware('auth')->name('chart-dashboard-hora');

Route::get('/contas/transacoes/{returnType?}', function($returnType = 'view', Illuminate\Http\Request $request){
    $contasController = app()->make('\App\Http\Controllers\ContasController');
    if($returnType == 'view')
        return $contasController->index();
    else
        return $contasController->getTransacoes($request);
})->middleware('auth')->name('chart-dashboard-hora');

Route::view('/registro', 'auth.registro');

Route::view('/investimentos/relatorios', 'investimentos.relatorios')->middleware('auth')->name('relatorios');

Route::view('/contas/abrirconta', 'contas.abrir')->name('abrir-conta');

Route::get('/minha-conta', function () {
    $minhaContaController = app()->make('\App\Http\Controllers\Auth\MinhaContaController');
    return $minhaContaController->index();
})->name('minha-conta')->middleware('auth');

Route::get('/auth/getPreferences/{returnType?}', function($returnType = 'view'){
    $minhaContaController = app()->make('\App\Http\Controllers\Auth\MinhaContaController');
    if($returnType == 'view')
        return $minhaContaController ->index();
    else
        return $minhaContaController ->getUserPreferences();
})->middleware('auth')->name('chart-dashboard-hora');

Route::post('/auth/preferencias', function(Illuminate\Http\Request $request){
    $minhaContaController = app()->make('\App\Http\Controllers\Auth\MinhaContaController');
    return $minhaContaController->store($request);

})->middleware('auth')->name('save-preferencias');

Route::post('/contas/criar', function(Illuminate\Http\Request $request){
    $contasController = app()->make('\App\Http\Controllers\ContasController');
    return $contasController->storeConta($request);

})->middleware('auth')->name('criar-conta');

Route::post('/contas/apagar', function(Illuminate\Http\Request $request){
    $contasController = app()->make('\App\Http\Controllers\ContasController');
    return $contasController->deletarConta($request);

})->middleware('auth')->name('deletar-conta');

Route::get('/investimentos/relatorios/{returnType?}', function($returnType = 'view'){
    $investimentoController = app()->make('\App\Http\Controllers\RelatorioInvestimentoController');
    if($returnType == 'view')
        return view('investimentos.relatorios');
    else
        return $investimentoController ->getPorcentagensLucro();
})->middleware('auth');

Route::prefix('niquelino')->group(function () {

    Route::get('/home', function(){
        $niquelinoController = app()->make('\App\Http\Controllers\Niquelino\NiquelinoController');
        return $niquelinoController ->index();
    })->middleware('auth')->name('niquelino.dashboard');

    Route::view('/configuracoes', 'niquelino.configuracoes')->middleware('auth')->name('niquelino.configuracoes');

});
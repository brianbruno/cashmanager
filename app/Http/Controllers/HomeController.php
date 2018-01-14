<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
      
        $user = Auth::user();
        
        $investimentosHoje = DB::table('investimentos')
                 ->select('id')
                 ->where('user_id', $user->user_id)
                 ->whereDate('created_at', DB::raw('CURDATE()'))
                 ->get();  
      
        return view('dashboard.home', ['investimentosHoje' => empty($investimentosHoje[0])]);      
    }

    public function getCincoUltimosInvestimentos () {
        $user = Auth::user();
        $ultimosCincoInvestimentos = DB::table('investimentos')
            ->select(DB::raw('(CASE WHEN tipo_investimento = "OPCAO" THEN "OPÇÃO" ELSE "CRIPTOMOEDA" END) AS tipo_investimento'),
                     DB::raw("format(valor,2,'de_DE') as valor"), DB::raw("format(lucro,2,'de_DE') as lucro"))
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        $arrayInvestimentos = array("investimentos" => $ultimosCincoInvestimentos);

        return $this->resposta($arrayInvestimentos, 'json');
    }

    public function getSaldo() {
        $user = Auth::user();
        $saldo = DB::table('saldo_contas')
            ->select(DB::raw("format(saldo,2,'de_DE') as saldo"))
            ->where('user_id', $user->user_id, DB::raw('DATE(created_at) > (NOW() - INTERVAL 7 DAY)'))
            ->get();

        $arraySaldo = array("saldo" => $saldo);

        return $this->resposta($arraySaldo, 'json');
    }

    public function getLucro() {
        $user = Auth::user();
        $lucro = DB::table('investimentos')
            ->select(DB::raw('format(COALESCE(SUM(lucro),0),2,"de_DE") as lucro'))
            ->where('user_id', $user->user_id)
            ->get();

        $arrayLucro = array("lucro" => $lucro);

        return $this->resposta($arrayLucro, 'json');
    }
}

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

    public function getChartData() {
        $user = Auth::user();

        $dias = [];
        $lucros = [];

        array_push($dias, date('Y-m-d', strtotime("-13 day")), date('Y-m-d', strtotime("-12 day")),
            date('Y-m-d', strtotime("-11 day")), date('Y-m-d', strtotime("-10 day")),
            date('Y-m-d', strtotime("-9 day")), date('Y-m-d', strtotime('-8day')),
            date('Y-m-d', strtotime("-7 day")), date('Y-m-d', strtotime("-6 day")),
            date('Y-m-d', strtotime("-5 day")), date('Y-m-d', strtotime("-4 day")),
            date('Y-m-d', strtotime("-3 day")), date('Y-m-d', strtotime("-2 day")),
            date('Y-m-d', strtotime('-1day')), date('Y-m-d'));

        foreach ($dias as $dia) {
            $lucro = DB::table('investimentos')
                ->select(DB::raw('COALESCE(SUM(lucro),0) as lucro'))
                ->where('user_id', $user->user_id)
                ->whereDate('created_at', $dia)
                ->get();
            array_push($lucros, $lucro[0]->lucro);
        }

        $arrayLucro = array("lucro" => $lucros, "dias" => $dias);

        return $this->resposta($arrayLucro, 'json');
    }

    public function getChartDataHora() {
        $user = Auth::user();

        $horas = [];
        $lucros = [];

        array_push($horas, date( 'd-m-Y H', strtotime("-23 hour")),
            date('d-m-Y H', strtotime("-22 hour")), date('d-m-Y H', strtotime("-21 hour")),
            date('d-m-Y H', strtotime("-20 hour")), date('d-m-Y H', strtotime('-19 hour')),
            date('d-m-Y H', strtotime("-18 hour")), date('d-m-Y H', strtotime("-17 hour")),
            date('d-m-Y H', strtotime("-16 hour")), date('d-m-Y H', strtotime("-15 hour")),
            date('d-m-Y H', strtotime("-14 hour")), date('d-m-Y H', strtotime("-13 hour")),
            date('d-m-Y H', strtotime("-12 hour")), date('d-m-Y H', strtotime("-11 hour")),
            date('d-m-Y H', strtotime("-10 hour")), date('d-m-Y H', strtotime('-9 hour')),
            date('d-m-Y H', strtotime("-8 hour")), date('d-m-Y H', strtotime("-7 hour")),
            date('d-m-Y H', strtotime("-6 hour")), date('d-m-Y H', strtotime("-5 hour")),
            date('d-m-Y H', strtotime("-4 hour")), date('d-m-Y H', strtotime("-3 hour")),
            date('d-m-Y H', strtotime("-3 hour")), date('d-m-Y H', strtotime('-1 hour')),
            date('d-m-Y H'));

        foreach ($horas as $hora) {
            $lucro = DB::table('investimentos')
                ->select(DB::raw('COALESCE(SUM(lucro),0) as lucro'))
                ->where('user_id', $user->user_id)
                ->where(DB::raw("date_format(created_at,'%d-%m-%Y %H')"), $hora)
                ->get();
            array_push($lucros, $lucro[0]->lucro);
        }

        $arrayLucro = array("lucro" => $lucros, "horas" => $horas);

        return $this->resposta($arrayLucro, 'json');
    }
}

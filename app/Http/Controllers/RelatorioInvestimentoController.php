<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/01/2018
 * Time: 21:20
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioInvestimentoController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPorcentagensLucro() {

        $user = Auth::user();

        $investimentos = DB::table('investimentos')
            ->select(DB::raw('(CASE WHEN tipo_investimento = "OPCAO" THEN "OPÇÃO" ELSE "CRIPTOMOEDA" END) AS tipo_investimento'),
                DB::raw("format(valor,2,'de_DE') as valor"), DB::raw("format(lucro,2,'de_DE') as lucro"),
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data'), DB::raw("format((lucro/valor)*100 ,2,'de_DE')AS porcentagem"))
            ->where('user_id', $user->user_id)
            ->where('status', 'F')
            ->orderBy('created_at', 'DESC')
            ->limit(20)
            ->get();

        $arrayInvestimentos = array("investimentos" => $investimentos);

        return $this->resposta($arrayInvestimentos, 'json');
    }

}
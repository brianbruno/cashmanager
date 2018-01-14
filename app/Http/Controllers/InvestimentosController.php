<?php

namespace App\Http\Controllers;
use App\Investment;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InvestimentosController extends Controller {
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

        return view('investimentos.home', ['investimentosHoje' => empty($investimentosHoje[0])]);
    }

    /**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $user = Auth::user();
        $contasController = new ContasController();
        $investimento = new Investment;

        $lucro = $request->input('lucro');
        $valor = $request->input('valor');
        $tipo_investimento = $request->input('tipo');
        $conta_id = $request->input('conta_id');

        $novoRequest = $request;

        if($lucro > 0)
            $novoRequest->replace(['tipo' => 'E', 'valor' => $lucro, 'conta_id' => $conta_id]);
        else
            $novoRequest->replace(['tipo' => 'S', 'valor' => $lucro*-1, 'conta_id' => $conta_id]);

        $investimento_id = $this->gerarInvestimentoId($user);
        $transacao = $contasController->storeTransacao($request);

        $investimento->user_id = $user->user_id;
        $investimento->trans_id = $transacao->trans_id;
        $investimento->investimento_id = $investimento_id;
        $investimento->tipo_investimento = $tipo_investimento;
        $investimento->valor = $valor;
        $investimento->lucro = $lucro;

        $investimento->save();
    }

    public function gerarInvestimentoId($user) {
        $investimento_prefix = date('d') . date('m'). date("y");

        $queryInvestimento = DB::table('investimentos')
            ->select(DB::raw('count(*) as investimentos_count'))
            ->where('investimento_id', 'like', $investimento_prefix.'%')
            ->get();

        $investimentosHoje = $queryInvestimento[0]->investimentos_count;
        $investimentosHoje = $investimentosHoje+1;

        $investimento_id = $investimento_prefix.str_pad($investimentosHoje, 4, "0", STR_PAD_LEFT);

        return $investimento_id;
    }

    public function getInvestimentosTabela () {
        $user = Auth::user();
        $ultimosCincoInvestimentos = DB::table('investimentos')
            ->select(DB::raw('(CASE WHEN tipo_investimento = "OPCAO" THEN "OPÇÃO" ELSE "CRIPTOMOEDA" END) AS tipo_investimento'),
                DB::raw("format(valor,2,'de_DE') as valor"), DB::raw("format(lucro,2,'de_DE') as lucro"),
                DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") AS data'))
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $arrayInvestimentos = array("investimentos" => $ultimosCincoInvestimentos);

        return $this->resposta($arrayInvestimentos, 'json');
    }
}

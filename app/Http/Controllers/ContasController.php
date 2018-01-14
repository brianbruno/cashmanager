<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 14/01/2018
 * Time: 11:09
 */

namespace App\Http\Controllers;

use App\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ContasController extends Controller {

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

        return view('contas.home');
    }

    public function storeTransacao(Request $request) {

        $user = Auth::user();

        $transacao_prefix = date('d') . date('m'). date("y") . date("H") . date("i");

        $queryTransacoes = DB::table('transacoes')
            ->select(DB::raw('count(*) as transacoes_count'))
            ->where('trans_id', 'like', $transacao_prefix.'%')
            ->limit(5)
            ->get();

        $queryTransacoes = $queryTransacoes[0]->transacoes_count;
        $transacoesAgora = $queryTransacoes+1;

        $trans_id = $transacao_prefix.str_pad($transacoesAgora, 3, "0", STR_PAD_LEFT).rand (1000000, 9999999);

        $transacao = new Transacao;

        $transacao->user_id = $user->user_id;
        $transacao->trans_id = $trans_id;
        $transacao->conta_id = $request->input('conta_id');
        $transacao->tipo = $request->input('tipo');
        $transacao->valor = $request->input('valor');

        $transacao->save();

        return $transacao;
    }

    public function getContas() {
        $user = Auth::user();
        $contas = DB::table('contas')
            ->select('conta_id', 'nome')
            ->where('user_id', $user->user_id)
            ->get();

        $arrayContas = array("contas" => $contas);

        return $this->resposta($arrayContas, 'json');
    }

}
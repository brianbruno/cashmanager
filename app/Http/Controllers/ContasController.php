<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 14/01/2018
 * Time: 11:09
 */

namespace App\Http\Controllers;

use App\Notifications\NovaTransacao;
use App\Transacao;
use App\Conta;
use App\Http\Controllers\Auth\MinhaContaController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Admin;


class ContasController extends Controller {

    use Notifiable;
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

        $user->notify(new NovaTransacao($transacao));

        return $transacao;
    }

    public function getContas($json = true) {
        $user = Auth::user();

        $contas = DB::table('contas')
            ->select('conta_id', 'nome', 'status')
            ->where('user_id', $user->user_id)
            ->where('status', 'A')
            ->get();

        if($json) {
            $arrayContas = array("contas" => $contas);
            return $this->resposta($arrayContas, 'json');
        }
        else
            return $contas;
    }

    public function getAllContas($json = true) {
        $user = Auth::user();

        $contas = DB::table('contas')
            ->select('conta_id', 'nome', 'status')
            ->where('user_id', $user->user_id)
            ->get();

        if($json) {
            $arrayContas = array("contas" => $contas);
            return $this->resposta($arrayContas, 'json');
        }
        else
            return $contas;
    }

    public function getDadosContas() {
        $user = Auth::user();

        $contas = DB::table('contas')
            ->select(DB::raw('count(conta_id) as contas'))
            ->where('user_id', $user->user_id)
            ->where('status', 'A')
            ->get();

        $transacoes = DB::table('transacoes')
            ->select(DB::raw('count(trans_id) as transacoes'))
            ->where('user_id', $user->user_id, DB::raw('DATE(created_at) > (NOW() - INTERVAL 30 DAY)'))
            ->get();

        $array = array("contas" => $contas, "transacoes" => $transacoes);

        return $this->resposta($array, 'json');
    }

    public function getTransacoes (Request $request) {
        $user = Auth::user();

        $tipo = $request->input('tipo');
        $conta = $request->input('conta_id');
        $itens_pagina = $request->input('per_page');
        $data = $request->input('data');

        $transacoes = DB::table('transacoes')
            ->join('contas', 'transacoes.conta_id', '=', 'contas.conta_id')
            ->select('contas.nome as conta_nome', 'transacoes.tipo as tipo', DB::raw("format(transacoes.valor ,2,'de_DE')as valor"),
                    DB::raw("date_format(transacoes.created_at,'%d-%m-%Y %H:%i:%s') as data"), 'transacoes.trans_id as trans_id')
            ->where('transacoes.user_id', $user->user_id)
            ->where('contas.status', 'A')
            ->when($tipo, function ($query) use ($tipo) {
                if(isset($tipo) && $tipo != 'T')
                    return $query->where('transacoes.tipo', $tipo);
            })
            ->when($conta, function ($query) use ($conta) {
                if(isset($conta) && $conta != 'T')
                    return $query->where('transacoes.conta_id', $conta);
            })
            ->when($data, function ($query) use ($data) {
                if(isset($data))
                    return $query->where(DB::raw("date_format(transacoes.created_at,'%d-%m-%y')"), $data);
            })
            ->limit($itens_pagina)
            ->get();

        $arrayTransacoes = array("transacoes" => $transacoes);

        return $this->resposta($arrayTransacoes, 'json');
    }

    public function storeConta (Request $request) {

        $user = Auth::user();
        $contas = $this->getAllContas(false);

        if(count($contas) < 10) {
            $proximaConta = count($contas) + 1;

            $conta_prefix = str_pad($proximaConta, 4, "0", STR_PAD_LEFT);

            $conta_id = $conta_prefix . substr($user->user_id, 0, -4);

            $conta = new Conta;

            $conta->user_id = $user->user_id;
            $conta->conta_id = $conta_id;
            $conta->nome = $request->input('nome');
            $conta->status = 'A';

            if ($conta->save())
                return $this->resposta(array("message" => $this->mensagens['CriadoSucesso']), 'json');
            else
                return $this->resposta(array("message" => $this->mensagens['CriadoErro']), 'json');
        } else {
            return $this->resposta(array("message" => $this->mensagens['LimiteMaximo']), 'json');
        }
    }

    public function deletarConta (Request $request) {

        $conta_id = $request->input('conta_id');
        $user = Auth::user();

        $minhaContaController = new MinhaContaController();
        $contaPrincipal = $minhaContaController->getContaPrincipal();

        $idContaPadrao = '0001' . substr($user->user_id, 0, -4);

        if($contaPrincipal == $conta_id) {
            $returnMessage = $this->mensagens['NaoExcluirPrincipal'];
        } else if($conta_id == $idContaPadrao) {
            $returnMessage = $this->mensagens['NaoExcluirPadrao'];
        } else {
            $conta = Conta::where('conta_id', '=' ,$conta_id)->firstOrFail();
            $conta->status = 'F';

            if($conta->save())
                $returnMessage = $this->mensagens['AtualizacaoSucesso'];
            else
                $returnMessage = $this->mensagens['AtualizacaoErro'];
        }

        return $this->resposta(array("message" => $returnMessage), 'json');
    }

    public function dadosServidor() {

        $contas = DB::table('contas')
            ->select(DB::raw('count(conta_id) as contas'))
            ->where('status', 'A')
            ->get();

        $transacoes = DB::table('transacoes')
            ->select(DB::raw('count(trans_id) as transacoes'))
            ->whereDay('created_at', date('d'))
            ->get();

        return [$contas, $transacoes];
    }

}
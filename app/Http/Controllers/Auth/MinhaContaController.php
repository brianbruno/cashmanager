<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 15/01/2018
 * Time: 19:35
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ContasController;
use App\User;
use App\UserPreferences;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MinhaContaController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $contasController;

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        return view('auth.me');
    }

    public function getUserPreferences() {
        $this->contasController = new ContasController();
        $user = Auth::user();

        $contas = $this->contasController->getContas(false);

        $conta_principal = $this->getContaPrincipal();

        $array = array("contas" => $contas, "preferencias" => $conta_principal);

        return $this->resposta($array, 'json');
    }

    public function getContaPrincipal () {
        $user = Auth::user();

        $query = DB::table('users_preferences')
            ->select('conta_principal', 'niquelino_ativo')
            ->where('user_id', $user->user_id)
            ->get();

        return $query;
    }

    public function getTelegramUserID () {
        $user = Auth::user();

        $query = DB::table('users_preferences')
            ->select('telegram_id')
            ->where('user_id', $user->user_id)
            ->get();

        return $query[0]->telegram_id;
    }

    public function store(Request $request) {

        $user = Auth::user();

        $conta_principal = $request->input('conta_principal');
        $niquelino_ativo = $request->input('niquelino_ativo');

        $userPreferences = UserPreferences::where('user_id', '=' ,$user->user_id)->firstOrFail();

        $userPreferences->conta_principal = $conta_principal;
        $userPreferences->niquelino_ativo = $niquelino_ativo;

        if($userPreferences->save())
            return $this->resposta(array("message" => $this->mensagens['AtualizacaoSucesso']), 'json');
        else
            return $this->resposta(array("message" => $this->mensagens['AtualizacaoErro']), 'json');

    }
}
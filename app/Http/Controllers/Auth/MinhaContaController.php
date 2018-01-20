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

        $conta_principal = DB::table('users_preferences')
            ->select('conta_principal')
            ->where('user_id', $user->user_id)
            ->get();

        $array = array("contas" => $contas, "preferencias" => $conta_principal);

        return $this->resposta($array, 'json');
    }

    public function store(Request $request) {

        $user = Auth::user();
        $conta_principal = $request->input('conta_principal');
        $userPreferences = UserPreferences::where('user_id', '=' ,$user->user_id)->firstOrFail();

        $userPreferences->conta_principal = $conta_principal;

        if($userPreferences->save())
            return $this->resposta(array("message" => $this->mensagens['AtualizacaoSucesso']), 'json');
        else
            return $this->resposta(array("message" => $this->mensagens['AtualizacaoErro']), 'json');

    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 14/01/2018
 * Time: 11:09
 */

namespace App\Http\Controllers\Niquelino;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserPreferences;


class NiquelinoController extends Controller {

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
    public function index() {
        $user = Auth::user();
        $userPreferences = UserPreferences::where('user_id', '=' ,$user->user_id)->firstOrFail();

        if($userPreferences->niquelino_ativo == 0)
            $niquelinoAtivo = false;
        else
            $niquelinoAtivo = true;

        return view('niquelino.home', ['niquelino_ativo' => $niquelinoAtivo]);

    }

}
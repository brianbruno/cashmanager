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
    public function store(Request $request)
    {

        $user = Auth::user();

        $investimento_prefix = date('d') . date('m'). date("y");

        $queryInvestimento = DB::table('investimentos')
            ->select(DB::raw('count(*) as investimentos_count'))
            ->where('investimento_id', 'like', $investimento_prefix.'%')
            ->limit(5)
            ->get();

        $investimentosHoje = $queryInvestimento[0]->investimentos_count;
        $investimentosHoje = $investimentosHoje+1;

        $investimento_id = $investimento_prefix.str_pad($investimentosHoje, 4, "0", STR_PAD_LEFT);


        $investimento = new Investment;

        $investimento->user_id = $user->user_id;
        $investimento->investimento_id = $investimento_id;
        $investimento->tipo_investimento = $request->input('tipo');
        $investimento->valor = $request->input('valor');
        $investimento->lucro = $request->input('lucro');

        $investimento->save();
    }
}

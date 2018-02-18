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

    public function getLucroBitCoin () {
        bcscale(8);

        $ganhos = DB::connection('mysql_niquelino')->table('ORDERS')
             ->select(DB::raw('(QUANTITY * RATE) AS GANHO'))
             ->where('TYPE', 'LIMIT_SELL')
             ->whereNotNull('CLOSED')
             ->get();

        $lucro = 0.0;

        foreach ($ganhos as $ganho) {
            $lucro = $lucro + $ganho->GANHO;
        }

        $total = bcmul($lucro, '0.01000000');

        return $this->resposta(array("lucro" => $total), 'json');
    }

    public function getUltimaVenda () {

        $ultimaVenda = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select(DB::raw('UNIX_TIMESTAMP(CLOSED) as ultimavenda'))
            ->where('TYPE', 'LIMIT_SELL')
            ->whereNotNull('CLOSED')
            ->latest('CLOSED')
            ->limit(1)
            ->get();

        $dataUltimaVenda = $ultimaVenda[0]->ultimavenda;

        $data = date("d/m/Y H:i:s", $dataUltimaVenda);


        return $this->resposta(array("ultimaVenda" => $data), 'json');
    }

    public function getOrdens () {
        $ordens = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select('MARKET' ,'TYPE', 'QUANTITY', 'RATE', 'QUANTITYREMAINING', DB::raw('DATE_FORMAT(OPENED, "%d/%m/%Y %H:%i:%s") as OPENED'))
            ->latest('OPENED')
            ->limit(25)
            ->get();

        return $this->resposta(array("ordens" => $ordens), 'json');
    }

}
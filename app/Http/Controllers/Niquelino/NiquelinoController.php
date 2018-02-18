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

    public function getLucroBitCoin ($data = null, $json= true) {
        bcscale(8);

        $ganhos = DB::connection('mysql_niquelino')->table('ORDERS')
             ->select(DB::raw('(QUANTITY * RATE) AS GANHO'))
             ->where('TYPE', 'LIMIT_SELL')
             ->whereNotNull('CLOSED')
             ->when($data, function ($query) use ($data) {
                if(isset($data))
                    return $query->where(DB::raw("date_format(ORDERS.CLOSED,'%d/%m/%Y')"), $data);
             })
             ->get();

        $lucro = 0.0;

        foreach ($ganhos as $ganho) {
            $lucro = $lucro + $ganho->GANHO;
        }

        $total = bcmul($lucro, '0.01000000');
        $conv = $this->convertBtc($total);

        $totalBrl = number_format($conv['brl'], 2, ',', '.');
        $totalUsd = number_format($conv['usd'], 2, ',', '.');

        if($json) {
            $resultado = $this->resposta(array("lucro" => $total, "lucrobrl" => $totalBrl, "lucrousd" => $totalUsd), 'json');
        }
        else
            $resultado = $total;

        return $resultado;
    }

    public function getLucroPorDia () {
        $dias = [];
        $lucros = [];

        array_push($dias, date('d/m/Y', strtotime("-6 day")),
            date('d/m/Y', strtotime("-5 day")), date('d/m/Y', strtotime("-4 day")),
            date('d/m/Y', strtotime("-3 day")), date('d/m/Y', strtotime("-2 day")),
            date('d/m/Y', strtotime('-1day')), date('d/m/Y'));

        foreach ($dias as $dia) {
            $lucroDia = $this->getLucroBitCoin($dia);
            array_push($lucros, $lucroDia->original['lucro']);
        }

        $arrayLucro = array("lucros" => $lucros, "dias" => $dias);

        return $this->resposta($arrayLucro, 'json');
    }

    public static function getUltimaVenda ($json = true) {

        $ultimaVenda = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select(DB::raw('UNIX_TIMESTAMP(CLOSED) as ultimavenda'))
            ->where('TYPE', 'LIMIT_SELL')
            ->whereNotNull('CLOSED')
            ->latest('CLOSED')
            ->limit(1)
            ->get();

        $dataUltimaVenda = $ultimaVenda[0]->ultimavenda;

        $data = date("d/m/Y H:i:s", $dataUltimaVenda);

        if($json) {
            $resultado = $this->resposta(array("ultimaVenda" => $data), 'json');
        }
        else
            $resultado = $data;

        return $resultado;
    }

    public function getOrdens () {
        $ordens = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select('MARKET' ,'TYPE', 'QUANTITY', 'RATE', 'QUANTITYREMAINING', DB::raw('DATE_FORMAT(OPENED, "%d/%m/%Y %H:%i:%s") as OPENED'))
            ->latest('OPENED')
            ->limit(25)
            ->get();

        return $this->resposta(array("ordens" => $ordens), 'json');
    }

    private function convertBtc($btc) {
        $url = "https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=BRL";
        $data = $this->request($url)[0];

        $usd = bcmul($btc, $data['price_usd'], 2);
        $brl = bcmul($btc, $data['price_brl'], 2);

        return array(
            'brl' => $brl,
            'usd' => $usd
        );
    }

    private function request($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true);
    }

}
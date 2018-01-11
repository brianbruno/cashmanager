<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller {
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
      
        return view('dashboard.home', ['investimentosHoje' => empty($investimentosHoje[0])]);      
    }
}

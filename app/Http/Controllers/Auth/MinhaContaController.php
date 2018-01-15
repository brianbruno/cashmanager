<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 15/01/2018
 * Time: 19:35
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;


class MinhaContaController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        return view('auth.me');
    }

}
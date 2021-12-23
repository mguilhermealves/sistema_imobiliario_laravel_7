<?php

namespace App\Http\Controllers;

use App\Tenant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tenants = Tenant::with('address')->orderBy('id', 'desc')->get();

        //dd($tenants);

        return view('home', [
            'tenants' => $tenants
        ]);
    }
}

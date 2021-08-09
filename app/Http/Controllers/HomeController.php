<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\User;
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
        $data['statuses']=Tasks::$statuses;
        return view('home',$data);
    }

    public function users(){
        return view('users',['users'=>User::all()]);
    }
}

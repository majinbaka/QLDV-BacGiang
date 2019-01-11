<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Group;

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
        $memberc = Member::count();
        $groups = Group::where('level', 1)->get();
        $members = Member::paginate(20);

        return view('home', compact('memberc', 'members', 'groups'))->withSuccess(session()->get( 'success' ));;
    }
}

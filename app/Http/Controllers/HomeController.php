<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Group;
use Auth;

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
        $user = Auth::user();
        if ($user->isAn('admin')){
            $memberc = Member::count();
            $groups = Group::where('level', 1)->get();
            $members = Member::paginate(20);

            return view('home', compact('memberc', 'members', 'groups'))->withSuccess(session()->get( 'success' ));
        }
        else{
            $group = $user->group;
            $ids = $group->getIdsG();
            $memberc = Member::whereIn('group_id', $ids)->count();
            $groups = Group::where('parent_id', $user->group_id)->where('level', $user->group->level + 1)->get();
            $members = Member::whereIn('group_id', $ids)->paginate(20);

            return view('home', compact('memberc', 'members', 'groups'))->withSuccess(session()->get( 'success' ));
        }
        

    }
}

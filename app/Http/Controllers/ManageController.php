<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Auth;
use Bouncer;

class ManageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (Bouncer::cannot('user')){
            return "Tính năng đang phát triển";
        }
        return view('manage.index');
    }

    public function setting()
    {
        return "Tính năng đang phát triển";
    }
}

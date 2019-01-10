<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class ManageController extends Controller
{
    public function index()
    {
        return view('manage.index');
    }

    public function setting()
    {
        return "Tính năng đang phát triển";
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class MemberController extends Controller
{
    public function create(){

    }

    public function edit(){

    }

    public function store(){

    }
    public function update(){

    }
    public function delete(){
        $member_ids = request()->get('member_ids');
        Member::whereIn('id', $member_ids)->delete();

        return \redirect()->back();
    }
}

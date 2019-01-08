<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class MemberController extends Controller
{
    public function search(){
        $code = request()->get('code');
        $fullname = request()->get('fullname');
        $group = request()->get('group');
        $members = Member::select(['code', 'fullname', 'group_id', 'position']);

        if ($code !== null)
            $members = $members->where('code','like', '%'.$code.'%');
        if ($fullname !== null)
            $members = $members->where('fullname','like', '%'.$fullname.'%');
        if ($group !== null)
            $members = $members->where('group_id', $group);
        $memberc = $members->count();
        $members = $members->paginate(20);

        return view('home')
            ->with('code', $code)
            ->with('fullname', $fullname)
            ->with('group', $group)
            ->with('members', $members)
            ->with('memberc', $memberc);
    }

    public function create(){
        return view('members.create');
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

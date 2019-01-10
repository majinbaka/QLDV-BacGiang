<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Group;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Auth;

class GroupController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $group_count = Group::count();
            $groups = Group::all();
            $groupsFilter = Group::where('level', 1)->get();
        }

        return view('groups.index', compact('group_count', 'groups', 'groupsFilter'))->withSuccess(session()->get( 'success' ));;
    }

    // public function create(){
    //     return view('groups.create');
    // }

    public function edit(){

    }

    public function store(){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'parent_id' => 'required',
        ],
        [
            'name.required' => 'Chưa nhập tên đơn vị cần tạo',
            'parent_id.required' => 'Đơn vị cấp trên không hợp lệ',
        ]
        );

        if ($validator->fails()) {
            return redirect('group')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $parent_id = 0;
            $level = 1;
            if (request()->get('parent_id') != '0'){
                $parent_group = Group::where('uuid', request()->get('parent_id'))->first();
                $parent_id = $parent_group->id;
                $level = $parent_group->level + 1;
            }
            
            $group = new Group;
            $group->name = \request()->get('name');
            $group->parent_id = $parent_id;
            $group->uuid = Str::uuid();
            $group->level = $level;
            $group->save();
        } catch(Exception $e){

        }

        return \redirect()->route('group.index');
    }
    public function update(){

    }
    public function delete(){
        $group_ids = request()->get('group_ids');
        if (is_array($group_ids))
        {
            $groups = Group::whereIn('uuid', $group_ids)->get();
            foreach ($groups as $group) {
                Group::where('parent_id', $group->id)->update(['parent_id' => 0]);
            }
            Group::whereIn('uuid', $group_ids)->delete();
            return redirect()->route('group.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('group.index')->withSuccess('Xoá thành công');
        }

        return \redirect()->back();
    }
}

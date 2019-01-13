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
            $groups = Group::paginate(20);
            $groupsFilter = Group::where('level', 1)->get();

            return view('groups.index', compact('group_count', 'groups', 'groupsFilter'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function show($uuid){
        $group = Group::where('uuid', $uuid)->first();
        $memberc = Member::where('group_id', $group->id)->count();
        $groups = Group::where('level', 1)->get();
        $members = Member::where('group_id', $group->id)->paginate(20);

        return view('home', compact('memberc', 'members', 'groups', 'group'));
    }

    public function edit($uuid){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $group = Group::where('uuid', $uuid)->first();
            $groups = Group::where('uuid', "<>", $uuid)->where('parent_id', 0)->get();

            return view('groups.edit')->with('groups', $groups)->with('group', $group)->withSuccess(session()->get('success'));
        }

        return "Tính năng đang phát triển";
    }

    public function store(){
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }

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

    public function update($uuid){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $group = Group::where('uuid', $uuid)->first();
            if (!$group){
                return redirect()->route('group.index')
                    ->withErrors('đơn vị không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
                'parent_id' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập tên đơn vị cần tạo',
                'parent_id.required' => 'Đơn vị cấp trên không hợp lệ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('group.edit', $uuid)
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

                $group->name = request()->get('name');
                $group->parent_id = $parent_id;
                $group->level = $level;
                $group->save();

                return redirect()->route('group.edit', $group->uuid)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $group_ids = request()->get('group_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
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

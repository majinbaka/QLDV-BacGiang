<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Group;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Auth;
use Bouncer;

class GroupController extends Controller
{
    public function index(){
        $user = Auth::user();
        if (Bouncer::can('group')){
            if ($user->isAn('admin')){
                $group_count = Group::count();
                $groups = Group::paginate(20);
                $groupsFilter = Group::where('level', 1)->get();
                $leftBarGroups = Group::where('level', 1)->get();
                return view('groups.index', compact('group_count', 'groups', 'groupsFilter','leftBarGroups'))->withSuccess(session()->get( 'success' ));
            }
            else{
                $group = $user->group;
                $ids = $group->getIdsG();
                $ids = array_diff($group->getIdsG(), [$user->group->id]);
                $group_count = count($ids);
                $groups = Group::whereIn('id', $ids)->paginate(20);
                $groupsFilter = Group::where('level', $user->group->level + 1)->where('parent_id', $user->group->id)->get();
                $leftBarGroups = Group::where('parent_id', $user->group_id)->where('level', $user->group->level + 1)->get();
                return view('groups.index', compact('group_count', 'groups', 'groupsFilter','leftBarGroups'))->withSuccess(session()->get( 'success' ));
            }
        }

        return "Tính năng đang phát triển";
    }

    public function show($uuid){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $group = Group::where('uuid', $uuid)->first();
            $ids = $group->getIdsG();
            $memberc = Member::whereIn('group_id', $ids)->count();
            $groups = Group::where('level', 1)->get();
            $members = Member::whereIn('group_id', $ids)->paginate(20);

            return view('home', compact('memberc', 'members', 'groups', 'group'));  
        }
        else{
            $user_group = $user->group_id;
            $group = Group::where('uuid', $uuid)->first();
            $has = $group->hasRelation($user_group);
            if (!$has) return \redirect()->route('home')->withErrors(['Không có quyền truy cập đơn vị này']);
            $ids = $group->getIdsG();
            $memberc = Member::whereIn('group_id', $ids)->count();
            $groups = Group::where('level', $user->group->level + 1)->where('parent_id', $user->group->id)->get();
            $members = Member::whereIn('group_id', $ids)->paginate(20);

            return view('home', compact('memberc', 'members', 'groups', 'group'));  
        }
    }

    public function list($uuid){
        $user = Auth::user();
        if (Bouncer::can('group')){
            if ($user->isAn('admin')){
                $group = Group::where('uuid', $uuid)->first();
                $ids = $group->getIdsG();
                $group_count = Group::count();
                $groups = Group::whereIn('id', $ids)->paginate(20);
                $groupsFilter = Group::where('level', 1)->get();
                $leftBarGroups = Group::where('level', 1)->get();
                return view('groups.index', compact('group_count', 'groups', 'groupsFilter','leftBarGroups', 'group'))->withSuccess(session()->get( 'success' ));
            }
            else{
                $group = Group::where('uuid', $uuid)->first();
                $user_group = $user->group_id;
                $has = $group->hasRelation($user_group);
                if (!$has) return \redirect()->route('group.index')->withErrors(['Không có quyền truy cập đơn vị này']);
                $ids = $group->getIdsG();
                $ids = array_diff($group->getIdsG(), [$user->group->id]);
                $group_count = count($ids);
                $groups = Group::whereIn('id', $ids)->paginate(20);
                $groupsFilter = Group::where('level', $user->group->level + 1)->where('parent_id', $user->group->id)->get();
                $leftBarGroups = Group::where('parent_id', $user->group_id)->where('level', $user->group->level + 1)->get();
                return view('groups.index', compact('group_count', 'groups', 'groupsFilter','leftBarGroups', 'group'))->withSuccess(session()->get( 'success' ));
            }
        }
    }

    public function edit($uuid){
        $user = Auth::user();
        if (Bouncer::can('group')){
            if ($user->isAn('admin')){
                $group = Group::where('uuid', $uuid)->first();
                $groups = Group::where('uuid', "<>", $uuid)->where('parent_id', 0)->get();
    
                return view('groups.edit')->with('groups', $groups)->with('group', $group)->withSuccess(session()->get('success'));
            }
            else{
                $user_group = $user->group_id;
                $group = Group::where('uuid', $uuid)->first();
                $has = $group->hasRelation($user_group);
                if (!$has) return \redirect()->route('home')->withErrors(['Không có quyền truy cập đơn vị này']);
                $ids = $group->getIdsG();
                $groups = Group::where('uuid', "<>", $uuid)->where('parent_id', $user_group)->get();

                return view('groups.edit')->with('groups', $groups)->with('group', $group)->withSuccess(session()->get('success'));
            }
        }

        return "Tính năng đang phát triển";
    }

    public function store(){
        if (Bouncer::cannot('group')){
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
            else{
                $user = Auth::user();
                if (!$user->isAn('admin')){
                    $parent_id = $user->group->id;
                    $level = $user->group->level + 1;
                }
            }
            
            $group = new Group;
            $group->name = \request()->get('name');
            $group->parent_id = $parent_id;
            $group->uuid = Str::uuid();
            $group->level = $level;
            $group->save();
        } catch(Exception $e){

        }

        return \redirect()->route('group.index')->withSuccess('Thêm đơn vị mới thánh công');
    }

    public function update($uuid){
        if (Bouncer::can('group')){
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
                else{
                    $user = Auth::user();
                    if (!$user->isAn('admin')){
                        $parent_id = $user->group->id;
                        $level = $user->group->level + 1;
                    }
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
        if (Bouncer::cannot('group')){
            return "Tính năng đang phát triển";
        }
        if (is_array($group_ids))
        {
            if ($user->isAn('admin')){
                $groups = Group::whereIn('uuid', $group_ids)->get();
                foreach ($groups as $group) {
                    Group::where('parent_id', $group->id)->update(['parent_id' => 0]);
                }
                Group::whereIn('uuid', $group_ids)->delete();
            }
            else{
                $group = $user->group;
                $ids = $group->getIdsG();
                $ids = Group::whereIn('id', $ids)->pluck('uuid')->toArray();
                if (empty(array_diff($group_ids, $ids))){
                    $groups = Group::whereIn('uuid', $group_ids)->get();
                    foreach ($groups as $group) {
                        Group::where('parent_id', $group->id)->update(['parent_id' => 0]);
                    }
                    Group::whereIn('uuid', $group_ids)->delete();
                }
            }

            return redirect()->route('group.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('group.index')->withSuccess('Xoá thành công');
        }

        return \redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isAn('admin')){
            $users = User::paginate(20);
            $user_count = User::count();

            return view('users.index')
                ->with('users',$users)
                ->with('user_count', $user_count)
                ->withSuccess(session()->get( 'success' ));
        }
        
        return "Tính năng đang phát triển";
    }

    public function create(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $groups = Group::all();

            return view('users.create')->with('groups', $groups);
        }

        return "Tính năng đang phát triển";
    }

    public function store(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $request = request()->all();
            if ($request['group'] === null)
                unset($request['group']);
            $validator = Validator::make($request, [
                'name' => 'required',
                'username' => 'required|regex:/^\S*$/u|unique:users,username',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'group' => 'exists:groups,uuid',
            ],
            [
                'name.required' => 'Chưa nhập tên người dùng',
                'username.required' => 'Chưa nhập tên đăng nhập',
                'username.regex' => 'Tên đăng nhập chưa đúng định dạng',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'email.required' => 'Chưa nhập email',
                'email.email' => 'Email chưa chính xác',
                'password.required' => 'Chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có tối thiểu 6 ký tự',
                'group.exists' => 'Đơn vị được chọn chưa tồn tại',
            ]
            );
    
            if ($validator->fails()) {
                return redirect()->route('user.create')
                            ->withErrors($validator)
                            ->withInput();
            }
    
            try{
                $parent_group = Group::where('uuid', request()->get('group'))->first();
                if(!$parent_group){
                    return redirect()->route('user.create')->withErrors(['Đơn vị không tồn tại']);
                }
                $group_id = $parent_group->id;
                $user = new User;
                $user->name = request()->get('name');
                $user->username = request()->get('username');
                $user->email = request()->get('email');
                $user->group_id = $group_id;
                $user->password = Hash::make(request()->get('password'));
                $user->uuid = Str::uuid();
                $user->can_create_user = request()->get('can_create_user') == "on" ? 1 : 0;
                $user->can_create_group = request()->get('can_create_group') == "on" ? 1 : 0;
                $user->save();

                return redirect()->route('user.index')->withSuccess('Tạo người dùng mới thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function edit($uuid){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $groups = Group::all();
            $user = User::where('uuid', $uuid)->first();

            return view('users.edit')->with('groups', $groups)->with('user', $user)->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function update($uuid){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $user = User::where('uuid', $uuid)->first();
            if (!$user){
                return redirect()->route('user.index')
                    ->withErrors('Người dùng không tồn tại');
            }

            $request = request()->all();
            if ($request['group'] === null)
                unset($request['group']);
            $validator = Validator::make($request, [
                'name' => 'required',
                'username' => 'required|regex:/^\S*$/u|unique:users,username,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id,
                'group' => 'exists:groups,uuid'
            ],
            [
                'name.required' => 'Chưa nhập tên người dùng',
                'username.required' => 'Chưa nhập tên đăng nhập',
                'username.regex' => 'Tên đăng nhập chưa đúng định dạng',
                'username.unique' => 'Tên đăng nhập đã tồn tại',
                'email.required' => 'Chưa nhập email',
                'email.unique' => 'Email đã tồn tại',
                'email.email' => 'Email chưa chính xác',
                'group.exists' => 'Đơn vị được chọn chưa tồn tại',
            ]
            );
    
            if ($validator->fails()) {
                return redirect()->route('user.edit', $user->uuid)
                            ->withErrors($validator)
                            ->withInput();
            }
    
            try{
                $parent_group = Group::where('uuid', request()->get('group'))->first();
                if(!$parent_group){
                    return redirect()->route('user.create')->withErrors(['Đơn vị không tồn tại']);
                }
                $group_id = $parent_group->id;
                $password = request()->get('password');
                $user = User::where('uuid', $uuid)->first();
                $user->name = request()->get('name');
                $user->username = request()->get('username');
                $user->email = request()->get('email');
                $user->group_id = $group_id;
                $user->can_create_user = request()->get('can_create_user') == "on" ? 1 : 0;
                $user->can_create_group = request()->get('can_create_group') == "on" ? 1 : 0;
                //validate password
                if (strlen($password) > 6){
                    $user->password = Hash::make($password);
                }
                else if (strlen($password) >= 1){
                    return redirect()->route('user.edit', $user->uuid)
                        ->withErrors(['Mật khẩu phải có tối thiểu 6 ký tự'])
                        ->withInput();
                }
                $user->save();

                return redirect()->route('user.edit', $user->uuid)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $user_ids = request()->get('user_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($user_ids))
        {
            User::whereIn('uuid', $user_ids)->delete();
            return redirect()->route('user.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('user.index')->withSuccess('Xoá thành công');
        }

        return \redirect()->back();
    }
}

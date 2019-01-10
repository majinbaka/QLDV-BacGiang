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
            $users = User::all();
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
                'group' => 'exists:groups,uuid'

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
                $user = new User;
                $user->name = request()->get('name');
                $user->username = request()->get('username');
                $user->email = request()->get('email');
                $user->password = Hash::make(request()->get('username'));
                $user->uuid = Str::uuid();
                $user->save();

                return redirect()->route('user.index')->withSuccess('Tạo người dùng mới thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }
}
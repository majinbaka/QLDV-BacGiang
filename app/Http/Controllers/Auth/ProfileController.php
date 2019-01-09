<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function changePassword(){
        return view('auth.passwords.change');
    }

    public function updatePassword(){

        request()->validate($this->rules(), $this->messages());
        $password = request()->get('old_password');
        $user = Auth::user();

        if (Hash::check($password, $user->password))
        {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            return view('auth.passwords.change')->withSuccess('Đổi mật khẩu thành công');
        }

        return view('auth.passwords.change')->withErrors('Mật khẩu cũ nhập lại chưa chính xác');
    }

    protected function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    protected function messages()
    {
        return [
            'old_password.required' => 'Chưa nhập mật khẩu cũ',
            'password.required' => 'Chưa nhập mật khẩu mới',
            'password.confirmed' => 'Chưa nhập xác nhận mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có độ dài tối thiểu 6 ký tự',
        ];
    }

    protected function resetPassword($user, $password)
    {

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }
}

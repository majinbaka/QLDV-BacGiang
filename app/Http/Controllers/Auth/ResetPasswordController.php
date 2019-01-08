<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $ps = PasswordReset::all();
        foreach($ps as $p){
            if (Hash::check($token, $p->token))
                return view('auth.passwords.reset')->with(
                    ['token' => $token, 'email' => $request->email]
                );
        }

        return redirect()->route('password.request');
    }

    protected function validationErrorMessages()
    {
        return [
            "email.*"=>"Email không đúng định dạng.",
            "password.*"=>"Mật khẩu phải có tối thiểu 6 ký tự và giống với mật khẩu xác nhận."
        ];
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email'], ['Chưa nhập email đăng ký hoặc email không đúng định dạng. Vui lòng thử lại']);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        if (in_array($response, ['passwords.password', 'passwords.reset', 'passwords.sent', 'passwords.user']))
            return back()->with('status', trans($response));
        else {
            return view('password.email')->with('status', trans($response));
        }
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Có lỗi xảy ra không gửi được email']);
    }
}

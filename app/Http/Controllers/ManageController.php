<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Member;
use Auth;
use Bouncer;
use Illuminate\Support\Facades\Validator;

class ManageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (Bouncer::cannot('user')){
            return "Tính năng đang phát triển";
        }
        return view('manage.index');
    }

    public function setting()
    {
        $email = Setting::where('setting_key','=','email')->first();
        if(!$email){
            $email = new Setting;
            $email->setting_key = 'email';
            $email->setting_value = '';
            $email->save();
        }
        $phone = Setting::where('setting_key','=','phone')->first();
        if(!$phone){
            $phone = new Setting;
            $phone->setting_key = 'phone';
            $phone->setting_value = '';
            $phone->save();
        }
        $copyright = Setting::where('setting_key','=','copyright')->first();
        if(!$copyright){
            $copyright = new Setting;
            $copyright->setting_key = 'copyright';
            $copyright->setting_value = '';
            $copyright->save();
        }
        return view('manage.setting',compact('email','phone','copyright'))->withSuccess(session()->get( 'success' ));
    }

    public function updateSetting(){
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'phone' => 'required',
            'copyright' => 'required',
        ],
        [
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Chưa nhập số điện thoại',
            'copyright.required' => 'Chưa nhập thông tin copyright',
        ]
        );
        if ($validator->fails()) {
            return redirect('manage/setting')
                ->withErrors($validator)
                ->withInput();
        }
        $email = Setting::where('setting_key','=','email')->first();
        if(!$email){
            $email = new Setting();
            $email->setting_key = 'email';
        }
        $email->setting_value = \request()->get('email');
        $email->save();

        $phone = Setting::where('setting_key','=','phone')->first();
        if(!$phone){
            $phone = new Setting();
            $phone->setting_key = 'phone';
        }
        $phone->setting_value = \request()->get('phone');
        $phone->save();

        $copyright = Setting::where('setting_key','=','copyright')->first();
        if(!$copyright){
            $copyright = new Setting();
            $copyright->setting_key = 'copyright';
        }
        $copyright->setting_value = \request()->get('copyright');
        $copyright->save();

        return \redirect()->route('manage.setting')->withSuccess('Sửa thông tin thành công');
    }
}

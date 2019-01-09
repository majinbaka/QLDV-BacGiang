@extends('layouts.app')
@section('content')
<div class="body" style="text-align:left">
<form method="POST" action="{{route('profile.update')}}">
    @csrf
    <div style="font-weight: 500;font-size: 20px;">ĐỔI MẬT KHẨU</div>
    <div style="margin-top: 35px;">
        <div class="group-login">
            <label class="change-pass-label">MẬT KHẨU CŨ</label>
            <input type="password" name="old_password" class="change-pass-login-input">
            @if ($errors->has('old_password'))
                <span style="color:red;">
                    <strong>{{ $errors->first('old_password') }}</strong>
                </span>
            @endif
        </div>
        <div class="group-login">
            <label class="change-pass-label">MẬT KHẨU MỚI</label>
            <input type="password" name="password" class="change-pass-login-input">
            @if ($errors->has('password'))
                <span style="color:red;">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="group-login">
            <label class="change-pass-label">NHẬP LẠI MẬT KHẨU MỚI</label>
            <input type="password" name="password_confirmation" class="change-pass-login-input">
        </div>
        <div class="login-item">
            <input class="login-button" type="submit" value="ĐẶT LẠI MẬT KHẨU">
        </div>
    </div>
</form>
</div>
@endsection

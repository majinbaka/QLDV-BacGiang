@extends('layouts.app')
@section('left-bar')
<span>THÔNG TIN TÀI KHOẢN</span>
<ul class="main-list">
    <li><a href="{{route('profile.edit')}}">Đổi mật khẩu</a></li>
</ul>
<script>
$(".has_sub").click(function() {
    $(this).toggleClass( "active" );
}) 
</script>
@endsection
@section('content')
<div class="search-area" style="height: 100%;margin-bottom: 15px;">
        <div class="title-bar">
                Đổi mật khẩu
            <div class="arrow-down"></div>
        </div>
<form method="POST" action="{{route('profile.update')}}">
    @csrf
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
        <div class="login-item" style="padding-left:10px">
            <input class="login-button" style="width:120px" type="submit" value="ĐẶT LẠI MẬT KHẨU">
        </div>
    </div>
</form>
</div>
@endsection

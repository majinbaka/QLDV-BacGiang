@extends('layouts.app')
@section('left-bar')
    <span>QUẢN TRỊ</span>
    <ul class="main-list">
        <li><a href="{{route('user.index')}}">Người dùng</a></li>
        @if (Auth::user()->isAn('admin'))
            <li><a href="{{route('manage.setting')}}">Thông tin cấu hình</a></li>
        @endif
    </ul>
@endsection
@section('content')
    <div class="content-crud"  style="margin-top:0px;font-size:12px;text-align:left;padding-left:20px">
        <div class="title" >CẬP NHẬT THÔNG TIN CẤU HÌNH</div>
        <div class="main">
            <form method="POST" action="{{route('manage.update')}}">
                @csrf
                <div>
                    <label class="form-label" style="margin-right:40px;">Email</label>
                    <input type="text" name="email" class="form-input" style="width: 200px" value="{{$email->setting_value}}">
                </div>
                <div>
                    <label class="form-label"  style="margin-right:16px;">Điện thoại</label>
                    <input type="text" name="phone" class="form-input" style="width: 200px" value="{{$phone->setting_value}}">
                </div>
                <div>
                    <label class="form-label"  style="margin-right:18px;">Copyright</label>
                    <input type="text" name="copyright" class="form-input" style="width: 200px" value="{{$copyright->setting_value}}">
                </div>
                <hr style="margin:10px 0px;">
                <input type="submit" value="Lưu" class="btn">
            </form>
        </div>
    </div>
@endsection

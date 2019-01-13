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
@endsection

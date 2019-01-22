@extends('layouts.app')
@section('left-bar')
    <span>DANH MỤC</span>
    <ul class="main-list">
        @if (Auth::user()->isAn('admin'))
            <li><a href="{{route('position.index')}}">Chức vụ</a></li>
            <li><a href="{{route('knowledge.index')}}">Trình độ</a></li>
            <li><a href="{{route('political.index')}}">Chính trị</a></li>
            <li><a href="{{route('it.index')}}">Tin học</a></li>
            <li><a href="{{route('english.index')}}">Tiêng anh</a></li>
            <li><a href="{{route('nation.index')}}">Dân tộc</a></li>
            <li><a href="{{route('religion.index')}}">Tôn Giáo</a></li>
        @endif
    </ul>
@endsection
@section('content')
    as
@endsection

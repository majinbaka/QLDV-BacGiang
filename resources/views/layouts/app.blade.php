<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600,700&amp;subset=vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500&amp;subset=vietnamese" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div id="header">
            <div class="container">
                <div class="logo">
                    <img src="{{asset('images/icon_doan.png')}}">
                </div>
                <div class="title">
                    PHẦN MỀM QUẢN LÝ ĐOÀN VIÊN
                </div>
                <div class="right-area">
                    <div class="span">
                        <span>{{Auth::user()->name}}</span>
                        <span>
                            <a href="{{route('profile.edit')}}">
                                <img class="notification-img" src="{{asset('images/doi mat khau icon.png')}}">
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <img class="notification-img" src="{{asset('images/Logout icon.png')}}" >
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </span>
                    </div>
                    <img class="avatar"  src="{{asset('images/icon_doan.png')}}">
                </div>
            </div>
        </div>
        <div class="top-navigation">
            <div class="container">
                <ul>
                    <li @if(in_array(\Route::currentRouteName(), ["home","member.search"])) class="active" @endif><a href="{{route('home')}}">HỒ SƠ ĐOÀN VIÊN</a></li>
                    <li @if(in_array(\Route::currentRouteName(), ["hom1e","memb1er.search"])) class="active" @endif><a href="">BÁO CÁO THỐNG KÊ</a></li>
                    <li @if(in_array(\Route::currentRouteName(), ["home1","mem1ber.search"])) class="active" @endif><a href="{{route('group.index')}}">DANH MỤC</a></li>
                    <li @if(in_array(\Route::currentRouteName(), ["manage.index","user.index", "user.create"])) class="active" @endif><a href="{{route('manage.index')}}">QUẢN TRỊ</a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notification')
        <div class="body container">
            <div class="left-bar">
                @yield('left-bar')
            </div>
            <div id="content">
                @yield('content')
            </div>
        </div>
        <footer>
            Copyright &copy; Tỉnh Đoàn Bắc Giang<br>
        </footer>
        @stack('script')
    </div>
</body>
</html>

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
    {{--<link href="{{ asset('css/style.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('css/prism.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <script src="{{asset('js/chosen.jquery.js')}}"></script>
    <script src="{{asset('js/prism.js')}}"></script>
    <script src="{{asset('js/init.js')}}"></script>
    <script src="{{asset('js/html-docx.js')}}"></script>
    <script src="{{asset('js/FileSaver.js')}}"></script>
</head>
<body>
    <div id="app">
        <div id="header">
            <div class="container">
                <div class="logo">
                    <img src="{{asset('images/icon_doan.png')}}">
                </div>
                <div class="title">
                    PHẦN MỀM QUẢN LÝ ĐOÀN VIÊN, THANH NIÊN
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
                    <img class="avatar"  src="{{asset('images/AVATA.png')}}">
                </div>
            </div>
        </div>
        <div class="top-navigation">
            <div class="container">
                <ul>
                    <li @if(in_array(\Route::currentRouteName(), ["home"])) class="active" @endif><a href="{{route('home')}}">THÔNG TIN CHUNG</a></li>
                    @can ('group')
                        <li @if(in_array(\Route::currentRouteName(), ["group.index"])) class="active" @endif><a href="{{route('group.index')}}">BỘ MÁY TỔ CHỨC</a></li>
                    @endcan
                    <li @if(in_array(\Route::currentRouteName(), ["members","member.search", "member.create", "member.edit", "group.show"]))  class="active" @endif><a href="{{route('members')}}">HỒ SƠ ĐOÀN VIÊN</a></li>
                    {{--@can ('home')--}}
                    <li @if(in_array(\Route::currentRouteName(), ["report.index"])) class="active" @endif><a href="{{route('report.index')}}">BÁO CÁO THỐNG KÊ</a></li>
                    {{--@endcan--}}
                    @can ('group')
                    <li @if(in_array(\Route::currentRouteName(), ["position.index","position.edit","political.index","political.edit","knowledge.index","knowledge.edit","it.index","it.edit","english.index","english.edit","blockmember.index","blockmember.edit"])) class="active" @endif><a href="{{route('position.index')}}">DANH MỤC</a></li>
                    @endcan
                    @can ('user')
                    <li @if(in_array(\Route::currentRouteName(), ["manage.index","user.index", "user.create"])) class="active" @endif><a href="{{route('user.index')}}">QUẢN TRỊ</a></li>
                    @endcan
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
            @php
                $copyright = \App\Setting::where('setting_key','=','copyright')->first();
                if(!$copyright){
                    $copyrightVal = 'Tỉnh Đoàn Bắc Giang';
                } else{
                    $copyrightVal = $copyright->setting_value;
                }
            @endphp
            Copyright &copy; {{$copyrightVal}}<br>
        </footer>
        @stack('script')
    </div>
</body>
</html>

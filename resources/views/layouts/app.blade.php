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
        <div class="header">
            <div class="container">
                <div class="logo">
                    <img src="{{asset('images/icon_doan.png')}}">
                </div>
                <div class="title">
                    PHẦN MỀM QUẢN LÝ ĐOÀN VIÊN
                </div>
                <div class="right-area">
                    <div class="span">
                        <span>Admin</span>
                        <span>
                            <img src="{{asset('images/thong bao icon.png')}}" class="notification-img" ><img class="notification-img" src="{{asset('images/doi mat khau icon.png')}}"><img class="notification-img" src="{{asset('images/Logout icon.png')}}" >
                        </span>
                    </div>
                    <img class="avatar"  src="{{asset('images/icon_doan.png')}}">
                </div>
            </div>
        </div>
        <div class="top-navigation">
            <div class="container">
                <ul>
                    <li class="active"><a href="">HỒ SƠ ĐOÀN VIÊN</a></li>
                    <li><a href="">BÁO CÁO THỐNG KÊ</a></li>
                    <li><a href="">DANH MỤC</a></li>
                    <li><a href="">QUẢN TRỊ</a></li>
                </ul>
            </div>
        </div>
        <div class="body container">
            <div class="left-bar">
                @yield('left-bar')
            </div>
            <div class="content">
                @yield('content')
            </div>
        </div>
        <footer>
            Copyright &copy; Tỉnh Đoàn Bắc Giang<br>
        </footer>
    </div>
</body>
</html>

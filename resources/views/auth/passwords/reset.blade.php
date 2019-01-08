<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phần mềm quản lý đoàn viên</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&amp;subset=vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=vietnamese" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <h1 class="title">ĐOÀN TNCS HỒ CHÍ MINH TỈNH BẮC GIANG</h1>
        <h2 class="sub-title">PHẦN MỀM QUẢN LÝ ĐOÀN VIÊN</h2>

        <div class="block-login" style="height: 430px;background-repeat:no-repeat;background-color:#fafcfd;">
            <div class="container">
                <form method="POST" action="{{route('password.update')}}">
                    @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="title-login">ĐẶT LẠI MẬT KHẨU</div>
                    <div style="margin-top: 35px;">
                        <div class="group-login">
                            <label for="">EMAIL</label>
                            <input type="email" name="email" class="login-input">
                            @if ($errors->has('email'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="group-login">
                            <label for="">MẬT KHẨU</label>
                            <input type="password" name="password" class="login-input">
                            @if ($errors->has('password'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="group-login">
                            <label for="">XÁC NHẬN MẬT KHẨU</label>
                            <input type="password" name="password_confirmation" class="login-input">
                        </div>
                        <div class="login-item">
                            <input class="login-button" type="submit" value="ĐẶT LẠI MẬT KHẨU">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            Copyright &copy; Tỉnh Đoàn Bắc Giang<br>
            Hỗ trợ kỹ thuật 0964.232.988<br>
            Email: ducdq@bacgiang.gov.vn<br>
        </footer>
    </div>
</body>
</html>


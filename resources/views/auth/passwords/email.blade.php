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

        <div class="block-login">
            <div class="container">
                <form method="POST" action="{{route('password.email')}}">
                    @csrf
                    <div class="title-login">QUÊN MẬT KHẨU</div>
                    <div style="margin-top: 35px;">
                        <div class="group-login">
                            <label for="">EMAIL</label>
                            <input type="text" name="email" class="login-input">
                        </div>
                        <div class="login-item">
                            <input class="login-button" type="submit" value="Gửi mail đặt lại mật khẩu">
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


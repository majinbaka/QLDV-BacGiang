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
                <form method="POST" action="{{route('login')}}">
                    @csrf
                    <div class="title-login">ĐĂNG NHẬP</div>
                    <div>
                        <div class="group-login">
                            <label for="">TÀI KHOẢN</label>
                            <input type="text" name="email" class="login-input">
                        </div>
                        <div class="group-login">
                            <label for="">MẬT KHẨU</label>
                            <input type="password" name="password" class="login-input input-password">
                            <span class="show-password">Hiển thị</span>
                        </div>
                        <div>
                            <input name="remember" class="remember" type="checkbox"><span class="remember-span"> Ghi nhớ</span>
                            <a class="forgot-href" href="/password/reset">Quên mật khẩu</a>
                        </div>
                        <div class="login-item">
                            <input class="login-button" type="submit" value="ĐĂNG NHẬP">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            <div class="container">
            Copyright &copy; Tỉnh Đoàn Bắc Giang<br>
            Hỗ trợ kỹ thuật 0964.232.988<br>
            Email: ducdq@bacgiang.gov.vn<br>
            </div>
        </footer>
    </div>
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <script>
        $(".show-password").click(function() {
            $(".input-password").prop("type", "text");
            if ($(".show-password").hasClass( "show" )){
                $(".show-password").removeClass( "show" );
                $(".input-password").prop("type", "password");
                $(".show-password").html( "Hiển thị" );
            }
            else{
                $(".show-password").addClass( "show" );
                $(".show-password").html( "Ẩn" );
            }
        });
    </script>
</body>
</html>


@extends('layouts.app')
@section('content')
    <div class="row">
        <label class="form-label" style="margin-right:2%; width: 10%">Tên tổ chức</label>
        <input type="text" name="group_name" id="group_name" style="width: 37%;height:25px;border: 1px solid #cccccc;border-radius: 3px" required>
        <label class="form-label" style="margin-right:2%;margin-left:2%; width: 10%">Tên báo cáo</label>
        <input type="text" name="report_name" id="report_name" style="width: 37%;height:25px;border: 1px solid #cccccc;border-radius: 3px" required>
    </div>
    <div class="mt-10 mb-15"></div>
    <div class="search-area report-form">
        <div class="title-bar">
            TIÊU CHÍ BÁO CÁO THỐNG KÊ
        </div>
        <div class="content-area">
            <form class="search-form" method="get" action="{{route('report.preview')}}">
                @csrf
                <div class="row">
                    <label class="form-label" for="child_group_id" style="padding-right: 40px" >Đơn vị</label>
                    <select name="child_group_id" id="child_group_id" class="width-200 form-select" style="margin-left: 45px">
                        <option value="0">Chọn...</option>
                        @foreach($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="position" >Chức vụ</label>
                    <select class="width-200 form-select" name="position" id="position">
                        <option value="">Chọn...</option>
                        @foreach ($positions as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="term" style="margin-left: 10px;">Nhiệm kỳ</label>
                    <select name="term" id="term" class="form-select {{ $errors->has('term') ? 'has-error' : ''}}">
                        <option>Chọn...</option>
                        <option value="2017" >2017</option>
                        <option value="2018" >2018</option>
                        <option value="2019" >2019</option>
                        <option value="2020" >2020</option>
                        <option value="2021" >2021</option>
                        <option value="2022" >2022</option>
                        <option value="2023" >2023</option>
                        <option value="2024" >2024</option>
                        <option value="2025" >2025</option>
                    </select>
                    <label class="form-label" for="gender">Giới tính</label>
                    <select name="gender" id="gender" class="form-select {{ $errors->has('gender') ? 'has-error' : ''}}">
                        <option value="">Chọn...</option>
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                    </select>
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label class="form-label" style="padding-right: 22px">Ngày sinh</label>
                    <label for="birthday_from" class="mini-label">Từ ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="birthday_from" id="birthday_from" class="form-input input-medium " style="width:85px;margin-left:0px;">
                    <label for="birthday_to" class="mini-label">Tới ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="birthday_to" id="birthday_to" class="form-input input-medium " style="width:85px;margin-left:0px;">

                    <label class="form-label" style="padding-right: 10px">Ngày vào đoàn</label>
                    <label for="join_date_from" class="mini-label">Từ ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="join_date_from" id="join_date_from" class="form-input input-medium " style="width:85px;margin-left:0px;">
                    <label for="birthday_to" class="mini-label">Tới ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="join_date_to" id="join_date_to" class="form-input input-medium " style="width:85px;margin-left:0px;">
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label class="form-label" for="knowledge" style="padding-right: 15px">Trình độ</label>
                    <select class="form-select" name="knowledge" id="knowledge">
                        <option value="">Chọn...</option>
                        @foreach ($knowledges as $k)
                            <option value="{{$k->id}}">{{$k->name}}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="political" style="margin-left: 51px;">Chính trị</label>
                    <select  class="form-select " name="political" id="political">
                        <option value="">Chọn...</option>
                        @foreach ($politicals as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="manage_object"  style="padding-right: 10px">Đối tượng quản lý</label>
                    <select name="manage_object" id="manage_object" class="form-select {{ $errors->has('manage_object') ? 'has-error' : ''}}">
                        <option value="1">Đoàn viên</option>
                        <option value="2">Thanh niên</option>
                        <option value="0" selected>Cả hai</option>
                    </select>
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="mt-25 mb-15"></div>
                @php
                    $districts = config('address.district');
                @endphp
                <div class="row">
                    <label class="form-label" style="padding-right: 24px">Quê quán</label>
                    <label for="current_district" class="mini-label">Huyện/ Thành phố</label>
                    <select name="current_district" id="current_district" class="form-select width-200 special" style="margin-left:0px">
                        <option value="0">Chọn...</option>
                        @foreach($districts as $key => $value)
                            @foreach($value as $k => $v)
                                <option value="{{$v}}" data-key="{{$k}}" data-city="{{$key}}">{{$v}}</option>
                            @endforeach
                        @endforeach
                    </select>

                    <label class="form-label" for="nation">Dân tộc</label>
                    <select class="input-medium form-select" name="nation" id="nation">
                        <option value="">Chọn...</option>
                        @foreach ($nations as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="religion" >Tôn giáo</label>
                    <select class="form-select" name="religion" id="religion">
                        <option value="">Chọn...</option>
                        @foreach ($religions as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="relation" style="padding-right: 10px">Tình trạng hôn nhân</label>
                    <select name="relation" id="relation" class="custom-select form-select">
                        <option value="">Chọn...</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="mb-15"></div>
                <div class="row">
                    <label class="form-label" for="relation" style="padding-right: 10px">Trưởng thành đoàn</label>
                    <select name="is_join_maturity_ceremony" id="is_join_maturity_ceremony" class="custom-select form-select">
                        <option value="">Chọn...</option>
                        <option value="1">Rồi</option>
                        <option value="0">Chưa</option>
                    </select>
                    <label class="form-label" for="relation" style="padding-right: 10px">Năm trưởng thành đoàn</label>
                    <select name="year_of_maturity_ceremony" id="year_of_maturity_ceremony" class="custom-select form-select">
                        <option value="0">Chọn...</option>
                        @for($i = 2019; $i > 1911; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="mb-15"></div>
                <div class="row">
                    <label>Chuyển nơi sinh hoạt</label>
                    <div class="mt-10 mb-15"></div>
                    <label class="form-label" style="padding-right: 27px">Chuyển đến</label>
                    <label for="from_place" class="mini-label">Nơi chuyển đến</label>
                    <input type="text" value="{{ old('from_place') }}" name="from_place" id="from_place" style="width: 280px" class="form-input input-x-large">
                    <label for="from_reason" class="mini-label">Lý do chuyển đến</label>
                    <input type="text" value="{{ old('from_reason') }}" name="from_reason" id="from_reason" style="width: 280px" class="form-input input-x-large">
                    <label for="from_date_from" class="mini-label">Từ ngày</label>
                    <input type="text" value="{{ old('from_date_from') }}" name="from_date_from" id="from_date_from" placeholder="dd/mm/yyyy" style="margin-right: 0px" class="form-input input-x-medium">
                    <label for="from_date_to" class="mini-label">Đến ngày</label>
                    <input type="text" value="{{ old('from_date_to') }}" name="from_date_to" id="from_date_to" placeholder="dd/mm/yyyy" style="margin-right: 0px" class="form-input input-x-medium">
                    <div class="mt-10 mb-15"></div>
                    <label class="form-label" style="padding-right: 37px">Chuyển đi</label>
                    <label for="from_place" class="mini-label">Nơi chuyển đi</label>
                    <input type="text" value="{{ old('to_place') }}" name="to_place" id="to_place" style="width: 280px" class="form-input input-x-large">
                    <label for="to_reason" class="mini-label">Lý do chuyển đi</label>
                    <input type="text" value="{{ old('to_reason') }}" name="to_reason" id="to_reason" style="width: 280px" class="form-input input-x-large">
                    <label for="to_date_from" class="mini-label">Từ ngày</label>
                    <input type="text" value="{{ old('to_date_from') }}" name="to_date_from" id="to_date_from" placeholder="dd/mm/yyyy" style="margin-right: 0px" class="form-input input-x-medium">
                    <label for="to_date_to" class="mini-label">Đến ngày</label>
                    <input type="text" value="{{ old('to_date_to') }}" name="to_date_to" id="to_date_to" placeholder="dd/mm/yyyy" style="margin-right: 0px" class="form-input input-x-medium">
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label >Xóa tên</label> <div class="mt-10 mb-15"></div>
                    <label class="form-label" for="is_go_far_away">Đi làm ăn xa</label>
                    <select id="is_go_far_away" name="is_go_far_away" class="custom-select form-select">
                        <option value="">Chọn...</option>
                        <option value="1">Có</option>
                        <option value="1">Không</option>
                    </select>
                </div>
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label class="form-label " for="delete_reason" style="">Lý do xóa tên</label>
                    <input type="text"  name="delete_reason" id="delete_reason" style="width: 500px;margin-right: 0px" class="form-input input-x-large " value="{{ old('delete_reason') }}">
                </div>
                <hr class="divider mt-10 mb-15">
                <div class="row">
                    <div class="mt-10 mb-15"></div>
                    <label class="form-label" for="rating">Đánh giá đoàn viên</label>
                    <select style="margin-right: 0px" name="rating" id="rating" class="custom-select input-large form-select {{ $errors->has('rating') ? 'has-error' : ''}}">
                        <option value="">Chọn...</option>
                        <option value="1">Xuất sắc</option>
                        <option value="2">Khá</option>
                        <option value="3">Trung bình</option>
                        <option value="4">Yếu</option>
                    </select>
                    <label class="form-label" for="rating_year" style="margin-left: 15px;padding-right: 20px">Năm đánh giá</label>
                    <select style="margin-right: 0px" name="rating_year" id="rating_year" class="custom-select input-large form-select {{ $errors->has('rating_year') ? 'has-error' : ''}}">
                        <option value="">Chọn...</option>
                        @for($i = 2019; $i > 1911; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="mt-30 mb-15"></div>
                <input type="hidden" name="start" id="start" value="1">
                <div class="row" style="text-align: center;vertical-align: middle">
                    <button type="submit" class="btn-accept btn btn-large btn-info">Chấp nhận</button>
                    <button type="button" class="btn-word btn btn-large btn-primary">In báo cáo word</button>
                    <button type="button" class="btn-excel btn btn-large btn-info"> In báo cáo excel</button>
                </div>
            </form>
            <div style="margin-top: 30px">
                <div id="preview_header"></div>
                <div id="preview_content"></div>
                <div id="preview_footer"></div>
                <div id="preview_pagination"></div>
            </div>
        </div>
    </div>
    <div id="loading"><img src="{{asset('images/giphy.gif')}}"></div>
@endsection
@push('script')
<script type="text/javascript">
    $("#child_group_id").chosen();
    $(document).ready(function () {
        $(".left-bar").remove();
        var groupId = $("#group_id").val();
        $("#child_group_id").val(groupId);
    });
    $(document).on('change','#group_id',function () {
        var groupId = $("#group_id").val();
        $("#child_group_id").val(groupId);
    });
    $(document).on('click','.btn-word',function (e) {
        e.preventDefault();
        var report_name = $("#report_name").val();
        var child_group_id = $("#child_group_id").val();
        var position = $("#position").val();
        var term = $("#term").val();
        var gender = $("#gender").val();
        var birthday_from = $("#birthday_from").val();
        var birthday_to = $("#birthday_to").val();
        var join_date_from = $("#join_date_from").val();
        var join_date_to = $("#join_date_to").val();
        var knowledge = $("#knowledge").val();
        var political = $("#political").val();
        var current_district = $("#current_district").val();
        var nation = $("#nation").val();
        var religion = $("#religion").val();
        var relation = $("#relation").val();
        var group_name = $("#group_name").val();
        var is_join_maturity_ceremony = $("#is_join_maturity_ceremony").val();
        var year_of_maturity_ceremony = $("#year_of_maturity_ceremony").val();
        var from_place = $("#from_place").val();
        var from_reason = $("#from_reason").val();
        var from_date_from = $("#from_date_from").val();
        var from_date_to = $("#from_date_to").val();
        var to_place = $("#to_place").val();
        var to_reason = $("#to_reason").val();
        var to_date_from = $("#to_date_from").val();
        var to_date_to = $("#to_date_to").val();
        var is_go_far_away = $("#is_go_far_away").val();
        var delete_reason = $("#delete_reason").val();
        var rating = $("#rating").val();
        var rating_year = $("#rating_year").val();
        if(child_group_id == 0){
            alert('Vui lòng chọn 1 đơn vị');
            return false;
        }
        if(!group_name){
            alert('Vui lòng nhập tên tổ chức');
            return false;
        }
        if(!report_name){
            alert('Vui lòng nhập tên báo cáo');
            return false
        }
        $("#loading").show();
        $.ajax({
            url: '/report/word',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data:{
                report_name:report_name,
                child_group_id:child_group_id,
                position:position,
                term:term,
                gender:gender,
                birthday_from:birthday_from,
                birthday_to:birthday_to,
                join_date_from:join_date_from,
                join_date_to:join_date_to,
                knowledge:knowledge,
                political:political,
                current_district:current_district,
                nation:nation,
                religion:religion,
                relation:relation,
                group_name:group_name,
                is_join_maturity_ceremony: is_join_maturity_ceremony,
                year_of_maturity_ceremony: year_of_maturity_ceremony,
                from_place:from_place,
                from_date_from:from_date_from,
                from_date_to:from_date_to,
                from_reason:from_reason,
                to_place:to_place,
                to_date_from:to_date_from,
                to_date_to:to_date_to,
                to_reason:to_reason,
                is_go_far_away:is_go_far_away,
                delete_reason:delete_reason,
                rating:rating,
                rating_year:rating_year
            },
            success: function(data) {
                var obj = $.parseJSON(data);
                downloadAll(obj,'word');
                $.ajax({
                    url:'/report/delete',
                    type:'post',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data:{
                        filelist:obj,
                        type:'word'
                    },
                    success:function () {
                        $("#loading").hide();
                    }
                });

            },
            error:function () {
                $("#loading").hide();
                alert('Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại sau.');
            }
        })
    });
    function downloadAll(urls, type) {
        jQuery.each(urls,function (index,item) {
            window.open('export/'+type+'/'+item,'_blank');
        });
    }
    $(document).on('click','.btn-excel',function (e) {
        e.preventDefault();
        var report_name = $("#report_name").val();
        var child_group_id = $("#child_group_id").val();
        var position = $("#position").val();
        var term = $("#term").val();
        var gender = $("#gender").val();
        var birthday_from = $("#birthday_from").val();
        var birthday_to = $("#birthday_to").val();
        var join_date_from = $("#join_date_from").val();
        var join_date_to = $("#join_date_to").val();
        var knowledge = $("#knowledge").val();
        var political = $("#political").val();
        var current_district = $("#current_district").val();
        var nation = $("#nation").val();
        var religion = $("#religion").val();
        var relation = $("#relation").val();
        var group_name = $("#group_name").val();
        var is_join_maturity_ceremony = $("#is_join_maturity_ceremony").val();
        var year_of_maturity_ceremony = $("#year_of_maturity_ceremony").val();
        var from_place = $("#from_place").val();
        var from_reason = $("#from_reason").val();
        var from_date_from = $("#from_date_from").val();
        var from_date_to = $("#from_date_to").val();
        var to_place = $("#to_place").val();
        var to_reason = $("#to_reason").val();
        var to_date_from = $("#to_date_from").val();
        var to_date_to = $("#to_date_to").val();
        var is_go_far_away = $("#is_go_far_away").val();
        var delete_reason = $("#delete_reason").val();
        var rating = $("#rating").val();
        var rating_year = $("#rating_year").val();
        if(child_group_id == 0){
            alert('Vui lòng chọn 1 đơn vị');
            return false;
        }
        if(!group_name){
            alert('Vui lòng nhập tên tổ chức');
            return false;
        }
        if(!report_name){
            alert('Vui lòng nhập tên báo cáo');
            return false
        }
        $("#loading").show();
        $.ajax({
            url: '/report/excel',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data:{
                report_name:report_name,
                child_group_id:child_group_id,
                position:position,
                term:term,
                gender:gender,
                birthday_from:birthday_from,
                birthday_to:birthday_to,
                join_date_from:join_date_from,
                join_date_to:join_date_to,
                knowledge:knowledge,
                political:political,
                current_district:current_district,
                nation:nation,
                religion:religion,
                relation:relation,
                group_name:group_name,
                is_join_maturity_ceremony: is_join_maturity_ceremony,
                year_of_maturity_ceremony: year_of_maturity_ceremony,
                from_place:from_place,
                from_date_from:from_date_from,
                from_date_to:from_date_to,
                from_reason:from_reason,
                to_place:to_place,
                to_date_from:to_date_from,
                to_date_to:to_date_to,
                to_reason:to_reason,
                is_go_far_away:is_go_far_away,
                delete_reason:delete_reason,
                rating:rating,
                rating_year:rating_year
            },
            success: function(data) {
                var obj = $.parseJSON(data);
                downloadAll(obj,'excel');
                $.ajax({
                    url:'/report/delete',
                    type:'post',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data:{
                        filelist:obj,
                        type:'excel'
                    },
                    success:function () {
                        $("#loading").hide();
                    }
                });

            },
            error:function () {
                $("#loading").hide();
                alert('Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại sau.');
            }
        })
    });

    $(document).on('click','.btn-accept',function (e) {
        e.preventDefault();
        var start = $("#start").val();
        var child_group_id = $("#child_group_id").val();
        var position = $("#position").val();
        var term = $("#term").val();
        var gender = $("#gender").val();
        var birthday_from = $("#birthday_from").val();
        var birthday_to = $("#birthday_to").val();
        var join_date_from = $("#join_date_from").val();
        var join_date_to = $("#join_date_to").val();
        var knowledge = $("#knowledge").val();
        var political = $("#political").val();
        var current_district = $("#current_district").val();
        var nation = $("#nation").val();
        var religion = $("#religion").val();
        var relation = $("#relation").val();
        var group_name = $("#group_name").val();
        var report_name = $("#report_name").val();
        var is_join_maturity_ceremony = $("#is_join_maturity_ceremony").val();
        var year_of_maturity_ceremony = $("#year_of_maturity_ceremony").val();
        var from_place = $("#from_place").val();
        var from_reason = $("#from_reason").val();
        var from_date_from = $("#from_date_from").val();
        var from_date_to = $("#from_date_to").val();
        var to_place = $("#to_place").val();
        var to_reason = $("#to_reason").val();
        var to_date_from = $("#to_date_from").val();
        var to_date_to = $("#to_date_to").val();
        var is_go_far_away = $("#is_go_far_away").val();
        var delete_reason = $("#delete_reason").val();
        var rating = $("#rating").val();
        var rating_year = $("#rating_year").val();
        if(child_group_id == 0){
            alert('Vui lòng chọn 1 đơn vị');
            return false;
        }
        if(!group_name){
            alert('Vui lòng nhập tên tổ chức');
            return false;
        }
        if(!report_name){
            alert('Vui lòng nhập tên báo cáo');
            return false
        }
        $("#loading").show();
        $.ajax({
            url: '/report/preview',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data:{
                child_group_id:child_group_id,
                position:position,
                term:term,
                gender:gender,
                birthday_from:birthday_from,
                birthday_to:birthday_to,
                join_date_from:join_date_from,
                join_date_to:join_date_to,
                knowledge:knowledge,
                political:political,
                current_district:current_district,
                nation:nation,
                religion:religion,
                relation:relation,
                start:start,
                report_name:report_name,
                group_name:group_name,
                is_join_maturity_ceremony: is_join_maturity_ceremony,
                year_of_maturity_ceremony: year_of_maturity_ceremony,
                from_place:from_place,
                from_date_from:from_date_from,
                from_date_to:from_date_to,
                from_reason:from_reason,
                to_place:to_place,
                to_date_from:to_date_from,
                to_date_to:to_date_to,
                to_reason:to_reason,
                is_go_far_away:is_go_far_away,
                delete_reason:delete_reason,
                rating:rating,
                rating_year:rating_year
            },
            success: function(data) {
                if(data.header != ''){
                    $("#preview_header").html(data.header);
                }

                $("#preview_content").html(data.contents);

                $("#preview_footer").html(data.footer);
                $("#start").val(data.start);
                $("#preview_pagination").html(data.page);
                $("#loading").hide();
            },
            error:function () {
                alert('Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại sau.');
            }
        })
    });

    $(document).on('click','.page-link',function (e) {
        e.preventDefault();
        var page = $(this).attr('data-page');
        if(!isNaN(page)){
            $('#start').val(page);
            $('.btn-accept').click();
        }
    });

</script>
@endpush

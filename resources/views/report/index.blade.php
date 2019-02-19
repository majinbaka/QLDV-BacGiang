@extends('layouts.app')
@section('content')
    <div class="row">
        <label class="form-label" style="margin-right:40px;">Tên tổ chức</label>
        <input type="text" name="group_name" id="group_name" style="width: 433px;height:25px;border: 1px solid #cccccc;border-radius: 3px">
        <label class="form-label" style="margin-right:40px;margin-left:40px">Tên báo cáo</label>
        <input type="text" name="report_name" id="report_name" style="width: 433px;height:25px;border: 1px solid #cccccc;border-radius: 3px">
    </div>
    <div class="mt-10 mb-15"></div>
    <div class="search-area report-form">
        <div class="title-bar">
            TIÊU CHÍ BÁO CÁO THỐNG KÊ
        </div>
        <div class="content-area">
            <form class="search-form" method="POST" action="#">
                @csrf
                <div class="row">
                    <label class="form-label" for="child_group_id" style="padding-right: 40px" >Đơn vị</label>
                    <select name="child_group_id" id="child_group_id" class="width-200 form-select" style="margin-left: 45px">
                        <option value="">Chọn...</option>
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
                    <label class="form-label" for="term" style="margin-right: 22px;margin-left: 10px;">Nhiệm kỳ</label>
                    <input type="text" name="term" id="term" class="input-x-large form-input" value="{{ old('term') }}">
                    <label class="form-label" for="gender">Giới tính</label>
                    <select name="gender" id="gender" class="form-select {{ $errors->has('gender') ? 'has-error' : ''}}">
                        <option value="">Chọn...</option>
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                    </select>
                </div>
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label class="form-label" style="padding-right: 15px">Ngày sinh</label>
                    <label for="birthday_from" class="mini-label">Từ ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="birthday_from" id="birthday_from">
                    <label for="birthday_to" class="mini-label">Tới ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="birthday_to" id="birthday_to">

                    <label class="form-label" style="padding-right: 10px">Ngày vào đoàn</label>
                    <label for="join_date_from" class="mini-label">Từ ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="join_date_from" id="join_date_from">
                    <label for="birthday_to" class="mini-label">Tới ngày</label>
                    <input type="text" placeholder="dd/mm/yyyy" name="join_date_to" id="join_date_to">

                    <label class="form-label" for="knowledge" style="padding-right: 21px;padding-left: 16px">Trình độ</label>
                    <select class="form-select" name="knowledge" id="knowledge">
                        <option value="">Chọn...</option>
                        @foreach ($knowledges as $k)
                            <option value="{{$k->id}}">{{$k->name}}</option>
                        @endforeach
                    </select>

                    <label class="form-label" for="political">Chính trị</label>
                    <select  class="form-select " name="political" id="political">
                        <option value="">Chọn...</option>
                        @foreach ($politicals as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-30 mb-15"></div>
                @php
                    $districts = config('address.district');
                @endphp
                <div class="row">
                    <label class="form-label" style="padding-right: 15px">Quê quán</label>
                    <label for="current_district" class="mini-label">Huyện/ Thành phố</label>
                    <select name="current_district" id="current_district" class="form-select width-200 special">
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
                <div class="mt-30 mb-15"></div>
                <div class="row" style="text-align: center;vertical-align: middle">
                    <button type="button" class="btn-word btn btn-large btn-primary">In báo cáo word</button>
                    <button type="button" class="btn-excel btn btn-large btn-info"> In báo cáo excel</button>
                </div>
            </form>
        </div>
    </div>
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
        $.ajax({
            url: '/report/word',
            type: 'get',
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
                relation:relation
            },
            success: function(data) {
                 window.location = '/export/word/'+data+'.doc';
            }
        })
    });

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
        $.ajax({
            url: '/report/excel',
            type: 'get',
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
                relation:relation
            },
            success: function(data) {
                window.location = '/export/excel/'+data+'.xls';
            }
        })
    });
</script>
@endpush

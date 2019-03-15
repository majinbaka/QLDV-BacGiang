@extends('layouts.app')
@section('left-bar')
    <div class="avatar-member">
        <div class="name">{{$member->fullname}}</div>
        <img src="{{Storage::url($member->avatar)}}" id="preview" style="max-width:207px;max-height:275px;margin:auto;margin-top:4px;">
    </div>
@endsection
@section('content')
    <div class="content-member">
        <div class="title">THÔNG TIN CHUNG</div>
        <div class="content-body">
            <form method="POST" action="{{route('member.update', $member->uuid)}}" id="form-create" enctype="multipart/form-data">
                @csrf
                <label class="form-label" for="fullname">Họ và tên</label>
                <input type="text"  name="fullname" class="form-input input-large {{ $errors->has('fullname') ? 'has-error' : ''}}" value="{{ old('fullname', $member->fullname ) }}">
                <label class="form-label" for="code" >Mã đoàn viên</label>
                <input type="text" name="code" class="form-input input-medium {{ $errors->has('code') ? 'has-error' : ''}}" value="{{ old('code', $member->code ) }}">
                <label class="form-label" for="birthday" >Ngày sinh</label>
                <input type="text" name="birthday" placeholder="dd/mm/yyyy" class="form-input input-medium {{ $errors->has('birthday') ? 'has-error' : ''}}"
                value="{{ old('birthday', Carbon\Carbon::createFromFormat('Y-m-d', $member->birthday)->format('d/m/Y')) }}">
                <label class="form-label" for="gender">Giới tính</label>
                <select name="gender"  class="custom-select input-medium form-select {{ $errors->has('gender') ? 'has-error' : ''}}">
                    <option value="1" @if(old('gender', $member->gender) == 1) selected @endif>Nam</option>
                    <option value="0" @if(old('gender', $member->gender) == 0) selected @endif>Nữ</option>
                </select>
                <div class="row" style="margin-bottom: 10px">
                    <label class="form-label" for="position" >Chức vụ</label>
                    <select class="input-large form-select {{ $errors->has('position') ? 'has-error' : ''}}" name="position">
                        @foreach ($positions as $p)
                            <option value="{{$p->id}}" @if(old('position', $member->position) == $p->id) selected @endif >{{$p->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="term">Nhiệm kỳ</label>
                    <select name="term" id="term" class="custom-select input-large form-select {{ $errors->has('term') ? 'has-error' : ''}}">
                        <option value="2017 - 2019" @if(old('manage_object', $member->term ) == '2017 - 2019') selected @endif>2017 - 2019</option>
                        <option value="2017 - 2022" @if(old('manage_object', $member->term ) == '2017 - 2022') selected @endif>2017 - 2022</option>
                        <option value="2018 - 2019" @if(old('manage_object', $member->term ) == '2018 - 2019') selected @endif>2018 - 2019</option>
                        <option value="2019 - 2020" @if(old('manage_object', $member->term ) == '2019 - 2020') selected @endif>2019 - 2020</option>
                        <option value="2019 - 2022" @if(old('manage_object', $member->term ) == '2019 - 2022') selected @endif>2019 - 2022</option>
                        <option value="2020 - 2021" @if(old('manage_object', $member->term ) == '2020 - 2021') selected @endif>2020 - 2021</option>
                        <option value="2021 - 2022" @if(old('manage_object', $member->term ) == '2021 - 2022') selected @endif>2021 - 2022</option>
                    </select>
                    <label class="form-label" for="manage_object" style="">Đối tượng quản lý</label>
                    <select style="margin-right: 0px" name="manage_object" id="manage_object" class="custom-select input-large form-select {{ $errors->has('manage_object') ? 'has-error' : ''}}">
                        <option value="1" @if(old('manage_object', $member->manage_object ) == 1) selected @endif>Đoàn viên</option>
                        <option value="2" @if(old('manage_object', $member->manage_object ) == 2) selected @endif>Thanh niên</option>
                        <option value="0" @if(old('manage_object', $member->manage_object ) == 0) selected @endif>Cả hai</option>
                    </select>
                </div>

                <div class="row">
                    <label class="form-label" for="group_id" >Đơn vị</label>
                    <select name="group_id" id="group_id" class="input-x-large form-select {{ $errors->has('group_id') ? 'has-error' : ''}}">
                        @foreach ($groups as $g)
                            <option value="{{$g->uuid}}" @if(old('group_id', $member->group_id ) == $g->id) selected @endif>{{$g->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="block_member_id" >Khối đối tượng</label>
                    <select class="input-large form-select ml-0 block-members {{ $errors->has('block_member_id') ? 'has-error' : ''}}" name="block_member_id">
                        @foreach ($blockMembers as $p)
                            <option value="{{$p->id}}" @if(old('block_member_id', $member->block_member_id ) == $p->id) selected @endif>{{$p->name}}</option>
                        @endforeach
                    </select>
                </div>
                <hr class="divider mt-10 mb-15">
                <label class="form-label" for="nation">Dân tộc</label>
                <select class="input-medium form-select width-75 {{ $errors->has('nation') ? 'has-error' : ''}}" name="nation">
                    @foreach ($nations as $p)
                        <option value="{{$p->id}}" @if(old('nation', $member->nation ) == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="religion" style="padding-right: 20px">Tôn giáo</label>
                <select class="form-select input-medium width-75 {{ $errors->has('religion') ? 'has-error' : ''}}" name="religion">
                    @foreach ($religions as $p)
                        <option value="{{$p->id}}" @if(old('religion', $member->religion ) == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="relation" style="padding-right: 20px">Tình trạng hôn nhân</label>
                <select name="relation"  class="custom-select form-select input-medium width-75 {{ $errors->has('relation') ? 'has-error' : ''}}">
                    <option value="1" @if(old('relation', $member->relation ) == 1) selected @endif>Có</option>
                    <option value="0" @if(old('relation', $member->relation ) == 0) selected @endif>Không</option>
                </select>
                <label class="form-label" for="join_date" >Ngày vào đoàn</label>
                <input type="text" value="{{ old('join_date', Carbon\Carbon::createFromFormat('Y-m-d', $member->join_date)->format('d/m/Y'))}}" name="join_date" class="form-input input-medium join-date {{ $errors->has('join_date') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
                <div class="mt-10 mb-15"></div>
                <label class="form-label">Quê quán</label>
                <label for="city" class="mini-label">Tỉnh/ Thành phố</label>
                @php
                    $cities = config('address.city');
                    $districts = config('address.district');
                    $communes = config('address.commune');
                @endphp
                <select name="city" id="city" class="form-select input-x-medium special {{ $errors->has('city') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($cities as $key => $value)
                        <option value="{{$value}}" data-key="{{$key}}" @if(strtolower(old('city', $member->city )) == strtolower($value)) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
                <label for="district" class="mini-label">Quận/ Huyện</label>
                <select name="district" id="district" class="form-select input-x-medium special {{ $errors->has('district') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($districts as $key => $value)
                        @foreach($value as $k => $v)
                            <option value="{{$v}}" data-key="{{$k}}" data-city="{{$key}}" @if(strtolower(old('district', $member->district )) == strtolower($v)) selected @endif>{{$v}}</option>
                        @endforeach
                    @endforeach
                </select>
                <label for="commune" class="mini-label">Xã/ Phường</label>
                <select name="commune" id="commune" class="form-select input-x-medium special {{ $errors->has('commune') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($communes as $key => $value)
                        @foreach($value as $k => $v)
                            @foreach($v as $i => $j)
                                <option @if(strtolower(old('commune', $member->commune )) == strtolower($j)) selected @endif value="{{$j}}" data-key="{{$i}}" data-city="{{$key}}" data-district="{{$k}}">{{$j}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
                <label for="vilage" class="mini-label">Thôn, bản, TDP</label>
                <input type="text" value="{{ old('vilage', $member->vilage ) }}" name="vilage" class="form-input input-x-large special {{ $errors->has('vilage') ? 'has-error' : ''}}">
                <div class="mt-10 mb-15"></div>
                <label class="form-label" style="padding-right: 10px">Nơi ở hiện nay</label>
                <label for="current_city" class="mini-label">Tỉnh/ Thành phố</label>
                <select name="current_city" id="current_city" class="form-select input-x-medium special {{ $errors->has('current_city') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($cities as $key => $value)
                        <option value="{{$value}}" data-key="{{$key}}" @if(strtolower(old('current_city', $member->current_city )) == strtolower($value)) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
                <label for="current_district" class="mini-label">Quận/ Huyện</label>
                <select name="current_district" id="current_district" class="form-select input-x-medium special {{ $errors->has('current_district') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($districts as $key => $value)
                        @foreach($value as $k => $v)
                            <option value="{{$v}}" data-key="{{$k}}" data-city="{{$key}}" @if(strtolower(old('current_district', $member->current_district )) == strtolower($v)) selected @endif>{{$v}}</option>
                        @endforeach
                    @endforeach
                </select>
                <label for="current_commune" class="mini-label">Xã/ Phường</label>
                <select name="current_commune" id="current_commune" class="form-select input-x-medium special {{ $errors->has('current_commune') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($communes as $key => $value)
                        @foreach($value as $k => $v)
                            @foreach($v as $i => $j)
                                <option @if(strtolower(old('current_commune', $member->current_commune )) == strtolower($j)) selected @endif value="{{$j}}" data-key="{{$i}}" data-city="{{$key}}" data-district="{{$k}}">{{$j}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
                <label for="current_vilage" class="mini-label">Thôn, bản, TDP</label>
                <input type="text" value="{{ old('current_vilage', $member->current_vilage ) }}" name="current_vilage" class="form-input input-x-large special {{ $errors->has('current_vilage') ? 'has-error' : ''}}">

                <hr class="divider">
                <label class="form-label" for="knowledge" style="padding-right: 40px">Trình độ</label>
                <select class="form-select input-x-medium {{ $errors->has('knowledge') ? 'has-error' : ''}}" name="knowledge">
                    @foreach ($knowledges as $k)
                        <option value="{{$k->id}}" @if(old('knowledge', $member->knowledge ) == $k->id) selected @endif >{{$k->name}}</option>
                    @endforeach
                </select>

                <label class="form-label" for="political">Chính trị</label>
                <select  class="form-select input-x-medium {{ $errors->has('political') ? 'has-error' : ''}}" name="political">
                    @foreach ($politicals as $p)
                        <option value="{{$p->id}}" @if(old('political', $member->political ) == $p->id) selected @endif >{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="it_level">Tin học</label>
                <select class="form-select input-x-medium {{ $errors->has('it_level') ? 'has-error' : ''}}" name="it_level">
                    @foreach ($its as $p)
                        <option value="{{$p->id}}" @if(old('it_level', $member->it_level ) == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="english_level">Ngoại ngữ</label>
                <select class="form-select input-x-medium last-item {{ $errors->has('english_level') ? 'has-error' : ''}}" name="english_level">
                    @foreach ($englishs as $p)
                        <option value="{{$p->id}}" @if(old('english_level', $member->english_level ) == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <div class="mt-10"></div>
                <label class="form-label" for="english_level" style="margin-right:5px">Học vấn</label>
                <select style="margin-right: 18px;" class="form-select input-x-medium last-item {{ $errors->has('education_level') ? 'has-error' : ''}}" name="education_level">
                    @for($i=1;$i<13;$i++)
                        <option value="{{$i}}" @if($i==$member->education_level) selected @endif>{{$i}}/12</option>
                    @endfor
                </select>
                <label class="form-label" for="is_dangvien">Đảng viên</label>
                <input type="radio" class="{{ $errors->has('is_dangvien') ? 'has-error' : ''}}" @if(old('is_dangvien', $member->is_dangvien ) == 1) checked @endif name="is_dangvien" value="1"><label style="margin-right:13px;margin-left:6px">Có</label>
                <input type="radio" class="{{ $errors->has('is_dangvien') ? 'has-error' : ''}}" @if(old('is_dangvien', $member->is_dangvien ) == 0) checked @endif  name="is_dangvien" value="0"><label style="margin-left:6px;">Không</label>
                <label class="form-label" for="join_dang" style="margin-left: 30px">Ngày vào đảng</label>
                @if($member->join_dang)
                <input type="text" value="{{ old('join_dang', Carbon\Carbon::createFromFormat('Y-m-d', $member->join_dang)->format('d/m/Y'))}}" name="join_dang" class="form-input input-x-medium {{ $errors->has('join_dang') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
                @else
                <input type="text" value="{{old('join_dang')}}" name="join_dang" class="form-input input-x-medium {{ $errors->has('join_dang') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
                @endif
                <hr class="divider">
                <label class="form-label" for="is_join_maturity_ceremony">Trưởng thành đoàn</label>
                <input type="radio" class="{{ $errors->has('is_join_maturity_ceremony') ? 'has-error' : ''}}" name="is_join_maturity_ceremony" value="1" @if(old('is_join_maturity_ceremony', $member->is_join_maturity_ceremony ) == 1) checked @endif><label style="margin-right:13px;margin-left:6px">Rồi</label>
                <input type="radio" class="{{ $errors->has('is_join_maturity_ceremony') ? 'has-error' : ''}}" name="is_join_maturity_ceremony" value="0" @if(old('is_join_maturity_ceremony', $member->is_join_maturity_ceremony ) == 0) checked @endif><label style="margin-left:6px;">Chưa</label>
                <label class="form-label" for="year_of_maturity_ceremony" style="margin-left: 40px;padding-right:  0px">Năm</label>
                <select style="margin-right: 0px" name="year_of_maturity_ceremony" id="year_of_maturity_ceremony" class="custom-select input-large form-select {{ $errors->has('year_of_maturity_ceremony') ? 'has-error' : ''}}">
                    <option value="0" @if(strtolower(old('year_of_maturity_ceremony', $member->year_of_maturity_ceremony )) == 0) selected @endif></option>
                    @for($i = 2019; $i > 1911; $i--)
                        <option value="{{$i}}" @if(strtolower(old('year_of_maturity_ceremony', $member->year_of_maturity_ceremony )) == $i) selected @endif>{{$i}}</option>
                    @endfor
                </select>
                <div class="mt-10 mb-15"></div>
                <hr class="divider">
                <label>Chuyển nơi sinh hoạt</label>
                <div class="mt-10 mb-15"></div>
                <label class="form-label" style="padding-right: 27px">Chuyển đến</label>
                <label for="from_place" class="mini-label">Nơi chuyển đến</label>
                <input type="text" value="{{ old('from_place', $member->from_place ) }}" name="from_place" class="form-input input-x-large {{ $errors->has('from_place') ? 'has-error' : ''}}">
                <label for="from_reason" class="mini-label">Lý do chuyển đến</label>
                <input type="text" value="{{ old('from_reason',$member->from_reason) }}" name="from_reason"  class="form-input input-x-large {{ $errors->has('from_reason') ? 'has-error' : ''}}">
                <label for="from_date" class="mini-label">Ngày chuyển đến</label>
                @if($member->from_date)
                <input type="text" value="{{ old('from_date', Carbon\Carbon::createFromFormat('Y-m-d', $member->from_date)->format('d/m/Y'))}}" name="from_date" placeholder="dd/mm/yyyy" style="margin-right: 0px" class="form-input input-x-medium {{ $errors->has('from_date') ? 'has-error' : ''}}">
                @else
                <input type="text" value="{{old('from_date')}}" name="from_date" class="form-input input-x-medium {{ $errors->has('from_date') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
                @endif
                <div class="mt-10 mb-15"></div>
                <label class="form-label" style="padding-right: 37px">Chuyển đi</label>
                <label for="from_place" class="mini-label">Nơi chuyển đi</label>
                <input type="text" value="{{ old('to_place',$member->to_place) }}" name="to_place"  class="form-input input-x-large {{ $errors->has('to_place') ? 'has-error' : ''}}">
                <label for="to_reason" class="mini-label">Lý do chuyển đi</label>
                <input type="text" value="{{ old('to_reason',$member->to_reason) }}" name="to_reason"  class="form-input input-x-large {{ $errors->has('to_reason') ? 'has-error' : ''}}">
                <label for="to_date" class="mini-label">Ngày chuyển đi</label>
                @if($member->to_date)
                    <input type="text" value="{{ old('to_date', Carbon\Carbon::createFromFormat('Y-m-d', $member->to_date)->format('d/m/Y'))}}" name="to_date" placeholder="dd/mm/yyyy" style="margin-right: 0px" class="form-input input-x-medium {{ $errors->has('to_date') ? 'has-error' : ''}}">
                @else
                    <input type="text" value="{{old('to_date')}}" name="to_date" class="form-input input-x-medium {{ $errors->has('to_date') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
                @endif
                <hr class="divider">
                <label class="form-label">Xóa tên</label>
                <div class="mt-10 mb-15"></div>
                <label class="form-label" for="is_go_far_away">Đi làm ăn xa</label>
                <input type="radio" class="{{ $errors->has('is_go_far_away') ? 'has-error' : ''}}" name="is_go_far_away" value="1" @if(old('is_go_far_away', $member->is_go_far_away ) == 1) checked @endif><label style="margin-right:13px;margin-left:6px">Có</label>
                <input type="radio" class="{{ $errors->has('is_go_far_away') ? 'has-error' : ''}}" name="is_go_far_away" value="0" @if(old('is_go_far_away', $member->is_go_far_away ) == 0) checked @endif><label style="margin-left:6px;">Không</label>
                <label class="form-label " for="delete_reason" style="margin-left: 30px;padding-right: 20px">Lý do xóa tên</label>
                <input type="text"  name="delete_reason" style="width: 300px;margin-right: 0px" class="form-input input-x-large {{ $errors->has('delete_reason') ? 'has-error' : ''}}" value="{{ old('delete_reason',$member->delete_reason) }}">
                <div class="mt-10 mb-15"></div>
                <label class="form-label" for="rating">Đánh giá đoàn viên</label>
                <select style="margin-right: 0px" name="rating" id="rating" class="custom-select input-large form-select {{ $errors->has('rating') ? 'has-error' : ''}}">
                    <option value="1" @if(strtolower(old('rating', $member->rating )) == 1) selected @endif>Xuất sắc</option>
                    <option value="2" @if(strtolower(old('rating', $member->rating )) == 2) selected @endif>Khá</option>
                    <option value="3" @if(strtolower(old('rating', $member->rating )) == 3) selected @endif>Trung bình</option>
                    <option value="4" @if(strtolower(old('rating', $member->rating )) == 4) selected @endif>Yếu</option>
                </select>
                <label class="form-label" for="rating_year" style="margin-left: 15px;padding-right: 20px">Năm đánh giá</label>
                <select style="margin-right: 0px" name="rating_year" id="rating_year" class="custom-select input-large form-select {{ $errors->has('rating_year') ? 'has-error' : ''}}">
                    @for($i = 2019; $i > 1911; $i--)
                        <option value="{{$i}}" @if(strtolower(old('rating_year', $member->rating_year )) == $i) selected @endif>{{$i}}</option>
                    @endfor
                </select>
                <input type="file" name="avatar" id="avatar" style="display:none">
                <hr class="divider mt-10 mb-15">
            <input type="submit" value="Lưu" class="input-submit">
            </form>
        </div>
    </div>

    <div class="attachment">
            <div class="title">File đính kèm</div>
            <div class='content'>
                <div id="add_attachment" class="input-submit">Thêm</div>
                <div id="attachlist">
                    @foreach ($member->attachments as $item)
                        <span class="atle_{{$item->id}}">{{$item->name}}<span style="color:red;margin:0;cursor:pointer" onclick="removeEE(this,{{$item->id}})"> Xoá</span></span>
                    @endforeach
                </div>
            </div>
        </div>
@endsection
@push('script')
<script>
    var at =1;
    $('.avatar-member').click(function(){
        $( "#avatar" ).trigger( "click" );
    });

    function readURL(input) {

if (input.files && input.files[0]) {
  var reader = new FileReader();

  reader.onload = function(e) {
    $('#preview').attr('src', e.target.result);
  }

  reader.readAsDataURL(input.files[0]);
}
}

$("#avatar").change(function() {
readURL(this);
});

$('#add_attachment').click(function(){
    var e = $("<input type='file' class='at_"+at+"' name='attachment[]' style='display:none' onchange='previewFile(this)'>");
    $('#form-create').append(e);
    e.trigger( "click" );
    });

    function previewFile(e){
        var fullPath = e.value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $('#attachlist').append('<span class="atl_'+at+'">'+filename+' <span style="color:red;margin:0;cursor:pointer" onclick="removeE(this,'+at+')">Huỷ</span></span>');
            at++;
        }
    }
function removeE(e, id){
    $('.at_'+id).remove();
    $('.atl_'+id).remove();
    $(e).remove();
}
function removeEE(e, id){
    $('.atle_'+id).remove();
    $(e).remove();
    var elem = $("<input type='text' name='remove_attachment[]' value='"+id+"' style='display:none'>");
    $('#form-create').append(elem);
}

    $(document).on('change','#city',function () {
        var v = $(this).val();
        if(v != 0){
            var c = $(this).find(':selected').attr('data-key');
            $('#district option').hide();
            $('#district option[data-city="'+c+'"]').show();
            $('#district option[value="0"]').show();
            $('#district').val(0);
            $('#commune option').hide();
            $('#commune option[data-city="'+c+'"]').show();
            $('#commune option[value="0"]').show();
            $('#commune').val(0);
        } else{
            $('#district option').show();
            $('#commune option').show();
        }
    });
    $(document).on('change','#district',function () {
        var v = $(this).val();
        if(v!=0){
            var d = $(this).find(':selected').attr('data-key');
            var c = $(this).find(':selected').attr('data-city');
            $('#commune option').hide();
            $('#commune option[data-city="'+c+'"][data-district="'+d+'"]').show();
            $('#commune option[value="0"]').show();
            $('#commune').val(0);
        } else{
            $('#commune option').show();
        }
    });

    $(document).on('change','#current_city',function () {
        var v = $(this).val();
        if(v != 0){
            var c = $(this).find(':selected').attr('data-key');
            $('#current_district option').hide();
            $('#current_district option[data-city="'+c+'"]').show();
            $('#current_district option[value="0"]').show();
            $('#current_district').val(0);
            $('#current_commune option').hide();
            $('#current_commune option[data-city="'+c+'"]').show();
            $('#current_commune option[value="0"]').show();
            $('#current_commune').val(0);
        } else{
            $('#current_district option').show();
            $('#current_commune option').show();
        }
    });
    $(document).on('change','#current_district',function () {
        var v = $(this).val();
        if(v!=0){
            var d = $(this).find(':selected').attr('data-key');
            var c = $(this).find(':selected').attr('data-city');
            $('#current_commune option').hide();
            $('#current_commune option[data-city="'+c+'"][data-district="'+d+'"]').show();
            $('#current_commune option[value="0"]').show();
            $('#current_commune').val(0);
        } else{
            $('#current_commune option').show();
        }
    });

    $("#group_id").chosen();
</script>
@endpush
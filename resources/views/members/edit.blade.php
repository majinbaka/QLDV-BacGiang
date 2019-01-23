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
                <input type="text"  name="fullname" class="form-input input-large {{ $errors->has('fullname') ? 'has-error' : ''}}" value="{{ $member->fullname }}">
                <label class="form-label" for="code" >Mã đoàn viên</label>
                <input type="text" name="code" class="form-input input-medium {{ $errors->has('code') ? 'has-error' : ''}}" value="{{ $member->code }}">
                <label class="form-label" for="birthday" >Ngày sinh</label>
                <input type="text" name="birthday" placeholder="dd/mm/yyyy" class="form-input input-medium {{ $errors->has('birthday') ? 'has-error' : ''}}" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $member->birthday)->format('d/m/Y')}}">
                <label class="form-label" for="gender">Giới tính</label>
                <select name="gender"  class="custom-select input-medium form-select {{ $errors->has('gender') ? 'has-error' : ''}}">
                    <option value="1" @if($member->gender == 1) selected @endif>Nam</option>
                    <option value="0" @if($member->gender == 0) selected @endif>Nữ</option>
                </select>
                <label class="form-label" for="position" >Chức vụ</label>
                <select class="input-large form-select {{ $errors->has('position') ? 'has-error' : ''}}" name="position">
                    @foreach ($positions as $p)
                        <option value="{{$p->id}}" @if($member->position == $p->id) selected @endif >{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="term" style="margin-right: 21px">Nhiệm kỳ</label>
                <input type="text" name="term" class="input-medium form-input {{ $errors->has('term') ? 'has-error' : ''}}"  value="{{$member->term}}">
                <div class="row">
                    <label class="form-label" for="group_id" >Đơn vị</label>
                    <select name="group_id" id="group_id" class="input-x-large form-select {{ $errors->has('group_id') ? 'has-error' : ''}}">
                        @foreach ($groups as $g)
                            <option value="{{$g->uuid}}" @if($member->group_id == $g->id) selected @endif>{{$g->name}}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="block_member_id" >Khối đối tượng</label>
                    <select class="input-large form-select ml-0 block-members {{ $errors->has('block_member_id') ? 'has-error' : ''}}" name="block_member_id">
                        @foreach ($blockMembers as $p)
                            <option value="{{$p->id}}" @if($member->block_member_id == $p->id) selected @endif>{{$p->name}}</option>
                        @endforeach
                    </select>
                </div>
                <hr class="divider mt-10 mb-15">
                <label class="form-label" for="nation">Dân tộc</label>
                <select class="input-medium form-select width-75 {{ $errors->has('nation') ? 'has-error' : ''}}" name="nation">
                    @foreach ($nations as $p)
                        <option value="{{$p->id}}" @if($member->nation == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="religion" style="padding-right: 20px">Tôn giáo</label>
                <select class="form-select input-medium width-75 {{ $errors->has('religion') ? 'has-error' : ''}}" name="religion">
                    @foreach ($religions as $p)
                        <option value="{{$p->id}}" @if($member->religion == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="relation" style="padding-right: 20px">Tình trạng hôn nhân</label>
                <select name="relation"  class="custom-select form-select input-medium width-75 {{ $errors->has('relation') ? 'has-error' : ''}}">
                    <option value="1" @if($member->relation == 1) selected @endif>Có</option>
                    <option value="0" @if($member->relation == 1) selected @endif>Không</option>
                </select>
                <label class="form-label" for="join_date" >Ngày vào đoàn</label>
                <input type="text" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $member->join_date)->format('d/m/Y')}}" name="join_date" class="form-input input-medium join-date {{ $errors->has('join_date') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
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
                        <option value="{{$value}}" data-key="{{$key}}" @if(strtolower($member->city) == strtolower($value)) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
                <label for="district" class="mini-label">Quận/ Huyện</label>
                <select name="district" id="district" class="form-select input-x-medium special {{ $errors->has('district') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($districts as $key => $value)
                        @foreach($value as $k => $v)
                            <option value="{{$v}}" data-key="{{$k}}" data-city="{{$key}}" @if(strtolower($member->district) == strtolower($v)) selected @endif>{{$v}}</option>
                        @endforeach
                    @endforeach
                </select>
                <label for="commune" class="mini-label">Xã/ Phường</label>
                <select name="commune" id="commune" class="form-select input-x-medium special {{ $errors->has('commune') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($communes as $key => $value)
                        @foreach($value as $k => $v)
                            @foreach($v as $i => $j)
                                <option @if(strtolower($member->commune) == strtolower($j)) selected @endif value="{{$j}}" data-key="{{$i}}" data-city="{{$key}}" data-district="{{$k}}">{{$j}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
                <label for="vilage" class="mini-label">Quê quán</label>
                <input type="text" value="{{ $member->vilage }}" name="vilage" class="form-input input-x-large special {{ $errors->has('vilage') ? 'has-error' : ''}}">
                <div class="mt-10 mb-15"></div>
                <label class="form-label" style="padding-right: 10px">Nơi ở hiện nay</label>
                <label for="current_city" class="mini-label">Tỉnh/ Thành phố</label>
                <select name="current_city" id="current_city" class="form-select input-x-medium special {{ $errors->has('current_city') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($cities as $key => $value)
                        <option value="{{$value}}" data-key="{{$key}}" @if(strtolower($member->current_city) == strtolower($value)) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
                <label for="current_district" class="mini-label">Quận/ Huyện</label>
                <select name="current_district" id="current_district" class="form-select input-x-medium special {{ $errors->has('current_district') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($districts as $key => $value)
                        @foreach($value as $k => $v)
                            <option value="{{$v}}" data-key="{{$k}}" data-city="{{$key}}" @if(strtolower($member->current_district) == strtolower($v)) selected @endif>{{$v}}</option>
                        @endforeach
                    @endforeach
                </select>
                <label for="current_commune" class="mini-label">Xã/ Phường</label>
                <select name="current_commune" id="current_commune" class="form-select input-x-medium special {{ $errors->has('current_commune') ? 'has-error' : ''}}">
                    <option value="0">Chọn...</option>
                    @foreach($communes as $key => $value)
                        @foreach($value as $k => $v)
                            @foreach($v as $i => $j)
                                <option @if(strtolower($member->current_commune) == strtolower($j)) selected @endif value="{{$j}}" data-key="{{$i}}" data-city="{{$key}}" data-district="{{$k}}">{{$j}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
                <label for="current_vilage" class="mini-label">Quê quán</label>
                <input type="text" value="{{ $member->current_vilage }}" name="current_vilage" class="form-input input-x-large special {{ $errors->has('current_vilage') ? 'has-error' : ''}}">

                <hr class="divider">
                <label class="form-label" for="knowledge" style="padding-right: 40px">Trình độ</label>
                <select class="form-select input-x-medium {{ $errors->has('knowledge') ? 'has-error' : ''}}" name="knowledge">
                    @foreach ($knowledges as $k)
                        <option value="{{$k->id}}" @if($member->knowledge == $k->id) selected @endif >{{$k->name}}</option>
                    @endforeach
                </select>

                <label class="form-label" for="political">Chính trị</label>
                <select  class="form-select input-x-medium {{ $errors->has('political') ? 'has-error' : ''}}" name="political">
                    @foreach ($politicals as $p)
                        <option value="{{$p->id}}" @if($member->political == $p->id) selected @endif >{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="it_level">Tin học</label>
                <select class="form-select input-x-medium {{ $errors->has('it_level') ? 'has-error' : ''}}" name="it_level">
                    @foreach ($its as $p)
                        <option value="{{$p->id}}" @if($member->it_level == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="english_level">Ngoại ngữ</label>
                <select class="form-select input-x-medium last-item {{ $errors->has('english_level') ? 'has-error' : ''}}" name="english_level">
                    @foreach ($englishs as $p)
                        <option value="{{$p->id}}" @if($member->english_level == $p->id) selected @endif>{{$p->name}}</option>
                    @endforeach
                </select>
                <div class="mt-10"></div>
                <label class="form-label" for="is_dangvien">Đảng viên</label>
                <input type="radio" class="{{ $errors->has('is_dangvien') ? 'has-error' : ''}}" @if($member->is_dangvien == 1) checked @endif name="is_dangvien" value="1"><label style="margin-right:13px;margin-left:6px">Có</label>
                <input type="radio" class="{{ $errors->has('is_dangvien') ? 'has-error' : ''}}" @if($member->is_dangvien == 0) checked @endif  name="is_dangvien" value="0"><label style="margin-left:6px;">Không</label>
                <label class="form-label" for="join_dang" style="margin-left: 30px">Ngày vào đảng</label>
                <input type="text" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $member->join_dang)->format('d/m/Y')}}" name="join_dang" class="form-input input-x-medium {{ $errors->has('join_dang') ? 'has-error' : ''}}" placeholder="dd/mm/yyyy">
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
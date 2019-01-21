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
            <label for="fullname" style="padding-right:33px">Họ và tên</label>
            <input type="text" name="fullname" style="width:140px;" value="{{$member->fullname}}">
            <label for="code" style="margin-left:38px;margin-right:25px">Mã đoàn viên</label>
            <input type="text" name="code" style="width:68px;" value="{{$member->code}}">
            <label for="birthday" style="margin-left:40px;margin-right:25px">Ngày sinh</label>
            <input type="text" name="birthday" placeholder="dd/mm/yyyy" style="width:68px;" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $member->birthday)->format('d/m/Y')}}">
            <label for="gender" style="margin-left:38px;margin-right:25px">Giới tính</label>
            <select name="gender" style="width:81px;">
                <option value="1" @if($member->gender == 1) selected @endif>Nam</option>
                <option value="0" @if($member->gender == 0) selected @endif>Nữ</option>
            </select>
            <label for="position"  style="padding-right:40px">Chức vụ</label>
            <select style="width:150px;" name="position">
                @foreach ($positions as $p)
                    <option @if($member->position == $p->id) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <label for="term"  style="margin-left:40px;margin-right:45px">Nhiệm kỳ</label>
            <input type="text" name="term" style="width:68px;" value="{{$member->term}}">
            <label for="group_id" style="padding-left:38px;padding-right:46px">Đơn vị</label>
            <select name="group_id" style="width:275px">
                @foreach ($groups as $g)
                    <option @if($member->group_id == $g->id) selected @endif value="{{$g->uuid}}">{{$g->name}}</option>
                @endforeach
            </select>
            <hr style="margin-top:9px;margin-bottom:14px">
            <label for="nation" style="margin-right:41px">Dân tộc</label>
            <select style="width:150px;" name="nation">
                @foreach ($nations as $p)
                    <option @if($member->nation == $p->id) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <label for="religion" style="margin-left:41px;margin-right:33px">Tôn giáo</label>
            <select style="width:150px;" name="religion">
                @foreach ($religions as $p)
                    <option @if($member->religion == $p->id) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <label for="relation" style="margin-left:50px;margin-right:33px">Tình trạng hôn nhân</label>
            <select name="relation" style="width:81px;">
                <option value="1" @if($member->relation == 1) selected @endif>Có</option>
                <option value="0" @if($member->relation == 0) selected @endif>Không</option>
            </select>
            <label for="join_date" style="margin-left:43px;margin-right:29px">Ngày vào đoàn</label>
            <input type="text" name="join_date" style="width:75px" placeholder="dd/mm/yyyy" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $member->join_date)->format('d/m/Y')}}"><br>
            <label style="padding-right:32px">Quê quán</label>
            <label for="city" class="mini-label">Tỉnh/ Thành phố</label>
            <input type="text" name="city" style="margin-right:40px;width:144px;margin-bottom:23px" value="{{$member->city}}">
            <label for="district" class="mini-label">Quận/ Huyện</label>
            <input type="text" name="district" style="margin-right:40px;width:144px" value="{{$member->district}}">
            <label for="commune" class="mini-label">Xã/ Phường</label>
            <input type="text" name="commune" style="margin-right:40px;width:144px" value="{{$member->commune}}">
            <label for="vilage" class="mini-label">Quê quán</label>
            <input type="text" name="vilage" style="width:175px" value="{{$member->vilage}}">

            <label style="padding-right:7px">Nơi ở hiện nay</label>
            <label for="current_city" class="mini-label">Tỉnh/ Thành phố</label>
            <input type="text" name="current_city" style="margin-right:40px;width:144px" value="{{$member->current_city}}">
            <label for="current_district" class="mini-label">Quận/ Huyện</label>
            <input type="text" name="current_district" style="margin-right:40px;width:144px" value="{{$member->current_district}}">
            <label for="current_commune" class="mini-label">Xã/ Phường</label>
            <input type="text" name="current_commune" style="margin-right:40px;width:144px" value="{{$member->current_commune}}">
            <label for="current_vilage" class="mini-label">Quê quán</label>
            <input type="text" name="current_vilage" style="width:175px;margin-bottom:26px" value="{{$member->current_vilage}}">

            <hr style="margin-bottom:13px">
            <label for="knowledge" style="margin-right:39px">Trình độ</label>
            <select style="width:95px;" name="knowledge">
                @foreach ($knowledges as $k)
                    <option @if($member->knowledge == $k->id) selected @endif value="{{$k->id}}">{{$k->name}}</option>
                @endforeach
            </select>

            <label for="political" style="margin-left:39px;margin-right:40px;">Chính trị</label>
            <select  style="width:95px;" name="political">
                @foreach ($politicals as $p)
                    <option @if($member->political == $p->id) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <label for="it_level" style="margin-left:45px;margin-right:46px">Tin học</label>
            <select style="width:95px;" name="it_level">
                @foreach ($its as $p)
                    <option @if($member->it_level == $p->id) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <label for="english_level" style="margin-left:45px;margin-right:29px">Ngoại ngữ</label>
            <select style="width:95px;" name="english_level">
                @foreach ($englishs as $p)
                    <option @if($member->english_level == $p->id) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <div style="margin-bottom:16px;"></div>
            <label for="is_dangvien" style="margin-right:29px">Đảng viên</label>
            <input @if($member->is_dangvien == 1) checked @endif type="radio" name="is_dangvien" value="1"><label style="margin-right:13px;margin-left:6px">Có</label>
            <input @if($member->is_dangvien == 0) checked @endif type="radio" name="is_dangvien" value="0"><label style="margin-left:6px;">Không</label>
            <label for="join_dang" style="margin-left:40px;margin-right:12px">Ngày vào đảng</label>
            <input type="text" name="join_dang" placeholder="dd/mm/yyyy" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $member->join_dang)->format('d/m/Y')}}">
            <hr style="margin-bottom:17px">
            <input type="file" name="avatar" id="avatar" style="display:none">
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
<script src="{{ asset('js/selectstyle2.js') }}"></script>
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
</script>
@endpush
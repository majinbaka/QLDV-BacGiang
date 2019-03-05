@extends('layouts.app')
@section('left-bar')
    @include('layouts.list_group', ['groups' => $groups])
@endsection
@section('content')
<div class="search-area">
    <div class="title-bar">
        TÌM KIẾM THÔNG TIN HỒ SƠ ĐOÀN VIÊN
        <div class="arrow-down"></div>
    </div>
    <div class="content-area">
        <form class="search-form" id="seach-form" method="POST" action="{{route('member.search')}}">
            @csrf
            <label>Mã đoàn viên</label>
        <input type="text" name="code" class="search-code" @isset($code)value="{{$code}}"@endisset>
            <label> Họ tên</label>
            <input type="text" name="fullname" class="search-fullname" @isset($fullname)value="{{$fullname}}"@endisset>
            <label> Đơn vị </label>
            <select name="group" id="group_id" class="custom-select " style="margin-right:10px;width: 165px;">
                <option value="">Chọn 1 đơn vị</option>
                @if (Auth::user()->isAn('admin'))
                    <option value="0">TỈNH ĐOÀN BẮC GIANG</option>
                @else
                    <option value="0">{{Auth::user()->group->name}}</option>
                @endif
                @foreach($groups as $gr)
                    <option value="{{$gr->uuid}}" @isset($group)@if($gr->id == $group->id) selected @endif @endisset>
                        {{$gr->name}}
                    </option>
                    @if($gr->childrens)
                        @include('groups._child_option', ['groupsFilter' => $gr->childrens, 'selected' => $gr->id])])
                    @endif
                @endforeach
            </select>
            @php
                if(session()->get('current_page')){
                    $page = session()->get('current_page');
                } else{
                    $page = 1;
                }
            @endphp
            <input type="hidden" id="page" name="page" value="{{$page}}">
            <input type="submit" value='Tìm kiếm' id="search">
        </form>
    </div>
</div>
<div class="body">
    <a class="addnew" href="{{route('member.create')}}" >Thêm mới</a>
    <a id="edit-user" class="addnew" href="#" style="display:none" >Sửa </a> 
    <button class="delete" id="removeItems">Xoá</button>
    Có tổng số <span style="color:#fc0202;font-weight:bold;line-height: 30px;">{{$memberc}}</span> đoàn viên
    <form id="member_form" method="POST">
        @csrf
        <table class="home-member-table">
            <thead>
                <td><input type="checkbox" id="checkAll"></td>
                <td>MÃ ĐOÀN VIÊN</td>
                <td>HỌ TÊN</td>
                <td>ĐƠN VỊ</td>
                <td>CHỨC VỤ</td>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td><input type="checkbox" name="member_ids[]" value="{{$member->uuid}}"></td>
                        <td onclick="window.location.href = '{{route('member.edit', $member->uuid)}}'">{{$member->code}}</td>
                        <td onclick="window.location.href = '{{route('member.edit', $member->uuid)}}'">{{$member->fullname}}</td>
                        @if($member->group)
                            <td>{{$member->group->name}}</td>
                        @else
                            <td></td>
                        @endif
                        @if($member->positionr)
                            <td>{{$member->positionr->name}}</td>
                        @else
                            <td></td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    {{ $members->links() }}
</div>
@endsection
@push('script')
{{--<script src="{{ asset('js/select.js') }}"></script>--}}
<script>
    $("#removeItems").click(function(e) {
        var confirma = confirm("Bạn chắc chắn muốn xoá ? ");
        if (confirma){
            e.preventDefault();
            $('#member_form').prepend('<input type="hidden" name="_method" value="DELETE">');
            $('#member_form').attr('action', "{{route('member.delete')}}").submit();
        }
    });
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    var $checkboxes = $('#member_form tbody input[type="checkbox"]');
    
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        var url = "/member/" + this.value + "/edit";
        if (countCheckedCheckboxes === 1){
            $("#edit-user").attr("href", url)
            $('#edit-user').show();
        }
        else{
            $('#edit-user').hide();
        }
    });
    $("#group_id").chosen({"width":"200px","enable_escape_special_char":true});
    $(document).on('click','.page-link',function (e) {
        e.preventDefault();
        var page = $(this).html();
        console.log(page);
        $('#page').val(page);
        $('#seach-form').submit();
        // if(href){
        //     var array = href.split('?page=');
        //     var page = array[1];
        //
        // }
    });
    $(document).on('change','.search-fullname',function () {
        $('#page').val(1);
    });
    $(document).on('change','.search-code',function () {
        $('#page').val(1);
    });
    $(document).on('change','#group_id',function () {
        $('#page').val(1);
    });
</script>
@endpush

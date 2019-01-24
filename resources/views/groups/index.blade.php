@extends('layouts.app')
@section('left-bar')
<span>DANH MỤC</span>
<ul class="main-list">
    <li><a href="{{route('group.index')}}">BỘ MÁY TỔ CHỨC</a></li>
</ul>
@endsection
@section('content')
<div class="search-area">
        <div class="title-bar">
            Tạo mới đơn vị
            <div class="arrow-down"></div>
        </div>
        <div class="content-area">
            <form class="search-form" method="POST" action="{{route('group.store')}}"> 
                @csrf
                <label>Tên đơn vị</label>
                <input type="text" name="name" class="search-code" style="width:300px">
                <label for="parent_id"> Đơn vị cấp trên</label>
                <select name="parent_id" class="custom-select" id="parent_id">
                    @if (Auth::user()->isAn('admin'))
                        <option value="0">TỈNH ĐOÀN BẮC GIANG</option>
                    @else
                        <option value="0">{{Auth::user()->group->name}}</option>
                    @endif
                    
                    @foreach($groupsFilter as $group)
                        <option value="{{$group->uuid}}">
                            --{{$group->name}}
                        </option>
                        @if($group->childrens)
                            @include('groups._child_option', ['groupsFilter' => $group->childrens, 'selected' => 0])])
                        @endif
                    @endforeach
                </select>
                <input type="submit" value='Thêm'>
            </form>
        </div>
    </div>
    <div class="body">
        <a id="edit-user" class="addnew" href="#" style="display:none">Sửa </a> 
        <button class="delete" id="removeItems">Xoá</button>
        Có tổng số <span style="color:#fc0202;font-weight:bold;line-height: 30px;">{{$group_count}}</span> đơn vị
        <form id="member_form" method="POST">
            @csrf
            <table>
                <thead>
                    <td><input type="checkbox" id="checkAll"></td>
                    <td>TÊN ĐƠN VỊ</td>
                    <td>ĐƠN VỊ CẤP TRÊN TRỰC TIẾP</td>
                    <td>ĐƠN VỊ CẤP TRÊN CAO NHẤT</td>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td><input type="checkbox" name="group_ids[]" value="{{$group->uuid}}"></td>
                            <td>{{$group->name}}</td>
                            <td>@isset($group->father){{$group->father->name}}@endisset</td>
                            <td>@isset($group->father){{$group->top_father->name}}@endisset</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        {{$groups->links()}}
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
            $('#member_form').attr('action', "{{route('group.delete')}}").submit();
        }
    });
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    var $checkboxes = $('#member_form tbody input[type="checkbox"]');
    
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        if (countCheckedCheckboxes === 1){
            $("#edit-user").attr("href", "/group/" + $checkboxes.filter(':checked')[0].value+ "/edit")
            $('#edit-user').show();
        }
        else{
            $('#edit-user').hide();
        }
    });
    $("#parent_id").chosen({"width":"200px","enable_escape_special_char":true});
</script>
@endpush
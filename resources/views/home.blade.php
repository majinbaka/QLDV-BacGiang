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
        <form class="search-form" method="POST" action="{{route('member.search')}}"> 
            @csrf
            <label>Mã đoàn viên</label>
        <input type="text" name="code" class="search-code" @isset($code)value="{{$code}}"@endisset>
            <label> Họ tên</label>
            <input type="text" name="fullname" class="search-fullname" @isset($fullname)value="{{$fullname}}"@endisset>
            <label> Đơn vị </label>
            <select name="group" class="custom-select ">
                <option value="">TỈNH ĐOÀN BẮC GIANG</option>
                @foreach($groups as $gr)
                    <option value="{{$gr->uuid}}" @isset($group)@if($gr->id == $group->id) selected @endif @endisset>
                        {{$gr->name}}
                    </option>
                    @if($gr->childrens)
                        @include('groups._child_option', ['groupsFilter' => $gr->childrens, 'selected' => $gr->id])])
                    @endif
                @endforeach
            </select>
            <input type="submit" value='Tìm kiếm'>
        </form>
    </div>
</div>
<div class="body">
    <a class="addnew" href="{{route('member.create')}}" >Thêm mới</a>
    <a class="addnew" href="#" >Sửa </a> 
    <button class="delete" id="removeItems">Xoá</button>
    Có tổng số <span style="color:#fc0202;font-weight:bold;line-height: 30px;">{{$memberc}}</span> đoàn viên
    <form id="member_form" method="POST">
        @csrf
        <table>
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
                        <td><input type="checkbox" name="member_ids[]" value="{{$member->id}}"></td>
                        <td>{{$member->code}}</td>
                        <td>{{$member->fullname}}</td>
                        <td>{{$member->group_id}}</td>
                        <td>{{$member->position}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    {{ $members->links() }}
</div>
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
    $('select').each(function() {
        var $this = $(this)
            , numberOfOptions = $(this).children('option').length;

        $this.addClass('s-hidden');

        $this.wrap('<div class="select"></div>');

        $this.after('<div class="styledSelect"></div>');

        var $styledSelect = $this.next('div.styledSelect');

        $styledSelect.text($this.children('option').eq(0).text());
        var $list = $('<ul />', {
            'class': 'options'
        }).insertAfter($styledSelect);

        for(var i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text()
                , rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }

        var $listItems = $list.children('li');

        $styledSelect.click(function(e) {
            e.stopPropagation();
            $('div.styledSelect.active').each(function() {
                $(this).removeClass('active').next('ul.options').hide();
            });
            $(this).toggleClass('active').next('ul.options').toggle();
        });

        $listItems.click(function(e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel'));
            $list.hide();
        });

        $(document).click(function() {
            $styledSelect.removeClass('active');
            $list.hide();
        });

    });
</script>
@endsection

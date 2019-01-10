@extends('layouts.app')
@section('left-bar')
<span>QUẢN TRỊ</span>
<ul class="main-list">
    <li><a href="{{route('user.index')}}">Người dùng</a></li>
    <li><a href="{{route('manage.setting')}}">Thông tin cấu hình</a></li>
</ul>
@endsection
@section('content')
    <div class="body" style="margin-top:0px">
        <a class="addnew" href="{{route('user.create')}}" >Thêm </a> 
        <a class="addnew" href="javascript:return;" disabled>Sửa </a> 
        <button class="delete" id="removeItems">Xoá</button>
        Có tổng số <span style="color:#fc0202;font-weight:bold;line-height: 30px;">{{$user_count}}</span> người dùng
        <form id="member_form" method="POST">
            @csrf
            <table>
                <thead>
                    <td><input type="checkbox" id="checkAll"></td>
                    <td>TÊN NGƯỜI DÙNG</td>
                    <td>EMAIL</td>
                    <td>TÊN ĐĂNG NHẬP</td>
                    <td>ĐƠN VỊ</td>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            @if($user->isAn('admin'))
                                <td></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->username}}</td>
                                <td>Quản lý toàn bộ các đơn vị</td>
                            @else
                                <td><input type="checkbox" name="user_ids[]" value="{{$user->uuid}}"></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->username}}</td>
                                <td>@isset($user->group){{$user->group->name}}@endisset</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
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

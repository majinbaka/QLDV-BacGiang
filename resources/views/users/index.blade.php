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
        <a id="edit-user" style="display:none" class="addnew" href="javascript:return;" >Sửa </a> 
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
        {{ $users->links() }}
    </div>
@endsection
@push('script')
<script src="{{ asset('js/select.js') }}"></script>
<script>
    $("#removeItems").click(function(e) {
        var confirma = confirm("Bạn chắc chắn muốn xoá ? ");
        if (confirma){
            e.preventDefault();
            $('#member_form').prepend('<input type="hidden" name="_method" value="DELETE">');
            $('#member_form').attr('action', "{{route('user.delete')}}").submit();
        }
    });
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('#edit-user').hide();
    });

    var $checkboxes = $('#member_form tbody input[type="checkbox"]');
    
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        var url = "/user/" + this.value + "/edit";
        if (countCheckedCheckboxes === 1){
            $("#edit-user").attr("href", url)
            $('#edit-user').show();
        }
        else{
            $('#edit-user').hide();
        }
    });
</script>
@endpush
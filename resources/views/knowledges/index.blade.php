@extends('layouts.app')
@section('left-bar')
    @include('layouts.danhmuc')
@endsection
@section('content')
<div class="search-area">
        <div class="title-bar">
            Tạo mới trình độ
            <div class="arrow-down"></div>
        </div>
        <div class="content-area">
            <form class="search-form" method="POST" action="{{route('knowledge.store')}}"> 
                @csrf
                <label>Tên trình độ</label>
                <input type="text" name="name" class="search-code" style="width:300px">
                <input type="submit" value='Thêm'>
            </form>
        </div>
    </div>
    <div class="body">
        <a id="edit-user" class="addnew" href="#" style="display:none">Sửa </a> 
        <button class="delete" id="removeItems">Xoá</button>
        <form id="member_form" method="POST">
            @csrf
            <table>
                <thead>
                    <td><input type="checkbox" id="checkAll"></td>
                    <td>TÊN TRÌNH ĐỘ</td>
                </thead>
                <tbody>
                    @foreach ($knowledges as $knowledge)
                        <tr>
                            <td><input type="checkbox" name="knowledge_ids[]" value="{{$knowledge->id}}"></td>
                            <td>{{$knowledge->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
@endsection
@push('script')
<script>
    $("#removeItems").click(function(e) {
        var confirma = confirm("Bạn chắc chắn muốn xoá ? ");
        if (confirma){
            e.preventDefault();
            $('#member_form').prepend('<input type="hidden" name="_method" value="DELETE">');
            $('#member_form').attr('action', "{{route('knowledge.delete')}}").submit();
        }
    });
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    var $checkboxes = $('#member_form tbody input[type="checkbox"]');
    
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        var url = "/knowledge/" + this.value + "/edit";
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
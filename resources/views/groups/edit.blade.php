@extends('layouts.app')
@section('left-bar')
    @include('layouts.danhmuc')
@endsection
@section('content')
<div class="content-crud"  style="margin-top:0px;font-size:12px;text-align:left;padding-left:20px">
    <div class="title" >SỬA THÔNG TIN ĐƠN VỊ</div>
    <div class="main">
    <form method="POST" action="{{route('group.update', $group->uuid)}}">
        @csrf
        <div>
            <label class="form-label" style="margin-right:83px;">Tên đơn vị</label>
            <input type="text" name="name" class="form-input" value="{{$group->name}}">
        </div>
        <div>
            <label class="form-label" style="margin-right:43px;">Đơn vị cấp trên</label>
            <select name="parent_id" class="custom-select form-select">
                <option value="0">TỈNH ĐOÀN BẮC GIANG</option>
                @foreach($groups as $gr)
                    <option value="{{$gr->uuid}}" @if($gr->id == $group->parent_id) selected @endif>
                        {{$gr->name}}
                    </option>
                    @if($gr->getExceptChildrens($group->uuid))
                        @include('groups._child_option', ['groupsFilter' => $gr->getExceptChildrens($group->uuid), 'selected' => $group->parent_id, 'except' => $group->uuid])
                    @endif
                @endforeach
            </select>
        </div>
        <hr style="margin:10px 0px;">
        <input type="submit" value="Lưu" class="btn">
    </form>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('js/select.js') }}"></script>
@endpush
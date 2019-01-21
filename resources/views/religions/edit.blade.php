@extends('layouts.app')
@section('left-bar')
    @include('layouts.danhmuc')
@endsection
@section('content')
<div class="content-crud"  style="margin-top:0px;font-size:12px;text-align:left;padding-left:20px">
    <div class="title" >SỬA THÔNG TIN </div>
    <div class="main">
    <form method="POST" action="{{route('religion.update', $religion->id)}}">
        @csrf
        <div>
            <label class="form-label" style="margin-right:83px;">Tên </label>
            <input type="text" name="name" class="form-input" value="{{$religion->name}}">
        </div>
        <hr style="margin:10px 0px;">
        <input type="submit" value="Lưu" class="btn">
    </form>
    </div>
</div>
@endsection
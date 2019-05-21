@extends('layouts.app')
@section('content')
    @if(session()->get('message_success'))
        <div class="my-notify-success">
            {{session()->get('message_success')}}
            @php session()->forget('message_success') @endphp
        </div>
    @endif
    @if(session()->get('message_error'))
        <div class="my-notify-error">
            {{session()->get('message_error')}}
            @php session()->forget('message_error') @endphp
        </div>
    @endif
    <div class="mt-10 mb-15"></div>
    <div class="search-area report-form">
        <div class="title-bar">
            NHẬP DỮ LIỆU TỪ EXCEL
        </div>
        <div class="content-area">
            <form class="search-form" method="post" action="{{route('member.importdata')}}" enctype="multipart/form-data">
                @csrf
                {{--<div class="row">--}}
                    {{--<label>Chú ý: Nếu muốn nhập cả dữ liệu ảnh nhận diện của thành viên, vui lòng tiến hành <a href="{{route('member.uploads')}}" target="_blank">Tải ảnh nhận diện</a> trước khi nhập dữ liệu.</label>--}}
                {{--</div>--}}
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label>Bước 1: Xuất file mẫu</label>
                    <button type="button" class="btn-export-sample btn btn-large btn-info">Xuất file mẫu</button>
                </div>
                <div class="mt-10 mb-15"></div>
                <div class="row">
                    <label>Bước 2: Chọn file dữ liệu</label>
                    <input class="form-input input-x-medium" type="file" name="import_xls" id="import_xls" style="width: 200px; margin-left: 19px" required accept=".xls,.xlsx">
                    <button type="submit" class="btn-import btn btn-large btn-primary">Chấp nhận</button>
                </div>
            </form>
        </div>
    </div>
    <div id="loading"><img src="{{asset('images/giphy.gif')}}"></div>
@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".left-bar").remove();
        });
        $(document).on('click','.btn-export-sample',function (e) {
            e.preventDefault();
            window.location.href  = '/export/import_data_sample.xlsx'
        });
        function downloadAll(urls, type) {
            jQuery.each(urls,function (index,item) {
                window.open('/export/'+type+'/'+item,'_blank');
            });
        }
    </script>
@endpush

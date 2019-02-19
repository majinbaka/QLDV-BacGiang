<div class="col-xs-12">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" colspan="11" style="text-align: center;font-weight: bold">THỐNG KÊ</th>
                        <th scope="col" colspan="11" style="color: #ff0000">Danh sách đoàn viên được kết nạp năm </th>
                        <th scope="col" colspan="11" >---------------</th>
                    </tr>
                    <tr></tr>
                    <tr>
                        <th scope="col" rowspan="3" style="width: 5;text-align: center;vertical-align: middle">Số thứ tự</th>
                        <th scope="col" rowspan="3" style="text-align: center; vertical-align: middle">Họ tên</th>
                        <th scope="col" colspan="2" style="width: 20;text-align: center;vertical-align: middle">Ngày, tháng, năm sinh</th>
                        <th scope="col" rowspan="3" style="text-align: center; vertical-align: middle">Dân tộc</th>
                        <th scope="col" rowspan="3" style="width:20; text-align: center; vertical-align: middle">Tôn giáo</th>
                        <th scope="col" rowspan="3" style="width:20; text-align: center; vertical-align: middle">Học vấn</th>
                        <th scope="col" rowspan="3" style="width:20; text-align: center; vertical-align: middle">Chuyên môn</th>
                        <th scope="col" rowspan="3" style="width:20; text-align: center; vertical-align: middle">Chức vụ, nghề nghiệp</th>
                        <th scope="col" rowspan="3" style="width:20; text-align: center; vertical-align: middle">Chi bộ</th>
                        <th scope="col" rowspan="3" style="width:20; text-align: center; vertical-align: middle">Đảng bộ</th>
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col" colspan="3" style="text-align: center; vertical-align: middle">Nam</th>
                        <th scope="col" colspan="3" style="text-align: center; vertical-align: middle">Nữ</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 0; @endphp
                    @foreach($result as $item)
                        @php
                            $i++;
                            $birthday = Carbon\Carbon::createFromFormat('Y-m-d',$item->birthday);
                        @endphp
                        <tr>
                            <td scope="col">{{$i}}</td>
                            <td scope="col">{{$item->fullname}}</td>
                            @if($item->gender == 1)
                                <td scope="col">{{$birthday->format('d/m/Y')}}</td>
                                <td scope="col"></td>
                            @else
                                <td scope="col"></td>
                                <td scope="col">{{$birthday->format('d/m/Y')}}</td>
                            @endif
                            <td scope="col">{{$item->nation}}</td>
                            <td scope="col">{{$item->religion}}</td>
                            <td scope="col"></td>
                            <td scope="col">{{$item->knowledge}}</td>
                            <td scope="col">{{$item->position}}</td>
                            <td scope="col">{{$item->group_name}}</td>
                            <td scope="col">{{$item->group_name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


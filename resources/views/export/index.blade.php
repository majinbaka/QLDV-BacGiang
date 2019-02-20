<div class="col-xs-12">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;">TỈNH ĐOÀN BẮC GIANG</th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" style="text-align: center;font-weight: bold;font-size: 14;">ĐOÀN THANH NIÊN CỘNG SẢN HỒ CHÍ MINH</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;;color: #ff0000">BCH ĐOÀN {{strtoupper($group_name)}}</th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;"></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;font-weight: bold">***</th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;"></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="11" style="text-align: center;font-weight: bold;">THỐNG KÊ</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="11" style="text-align: center;font-weight: bold;color: #ff0000;">Danh sách đoàn viên được kết nạp năm </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="11" style="text-align: center;font-weight: bold;">---------------</th>
                    </tr>
                    <tr></tr>
                    <tr>
                        <th scope="col" rowspan="2" style="width: 10;text-align: center;vertical-align: middle; border: 1px solid #000000">Số thứ tự</th>
                        <th scope="col" rowspan="2" style="width: 20;text-align: center; vertical-align: middle; border: 1px solid #000000">Họ tên</th>
                        <th scope="col" colspan="2" style="width: 30;text-align: center;vertical-align: middle; border: 1px solid #000000">Ngày, tháng, năm sinh</th>
                        <th scope="col" rowspan="2" style="width:15;text-align: center; vertical-align: middle; border: 1px solid #000000">Dân tộc</th>
                        <th scope="col" rowspan="2" style="width:20; text-align: center; vertical-align: middle; border: 1px solid #000000">Tôn giáo</th>
                        <th scope="col" rowspan="2" style="width:20; text-align: center; vertical-align: middle; border: 1px solid #000000">Học vấn</th>
                        <th scope="col" rowspan="2" style="width:30; text-align: center; vertical-align: middle; border: 1px solid #000000">Chuyên môn</th>
                        <th scope="col" rowspan="2" style="width:30; text-align: center; vertical-align: middle; border: 1px solid #000000">Chức vụ, nghề nghiệp</th>
                        <th scope="col" rowspan="2" style="width:30; text-align: center; vertical-align: middle; border: 1px solid #000000">Chi bộ</th>
                        <th scope="col" rowspan="2" style="width:30; text-align: center; vertical-align: middle; border: 1px solid #000000">Đảng bộ</th>
                    </tr>
                    <tr>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" colspan="1" style="width: 15;text-align: center; vertical-align: middle;font-style: italic;border: 1px solid #000000;">Nam</th>
                        <th scope="col" colspan="1" style="width: 15;text-align: center; vertical-align: middle;font-style: italic;border: 1px solid #000000;">Nữ</th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                        <th scope="col" style="border: 1px solid #000000"></th>
                    </tr>
                    </thead>
                    <tbody style="border: 1px solid #000000;">
                    @php $i = 0; @endphp
                    @foreach($result as $item)
                        @php
                            $i++;
                            $birthday = Carbon\Carbon::createFromFormat('Y-m-d',$item->birthday);
                        @endphp
                        <tr>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12;text-align: center; vertical-align: middle;">{{$i}}</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; vertical-align: middle;">{{$item->fullname}}</td>
                            @if($item->gender == 1)
                                <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$birthday->format('d/m/Y')}}</td>
                                <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;"></td>
                            @else
                                <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;"></td>
                                <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$birthday->format('d/m/Y')}}</td>
                            @endif
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->nation}}</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->religion}}</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->education_level}}/12</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->knowledge}}</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->position}}</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->group_name}}</td>
                            <td scope="col" style="border: 1px solid #000000;font-size: 12; text-align: center; vertical-align: middle;">{{$item->group_name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr></tr>
                    <tr>
                        <th scope="col" colspan="11" >* Tổng số đoàn viên ưu tú được kết nạp Đảng/tổng số đảng viên mới kết nạp trong toàn Đảng bộ : {{$i}}/ (Đạt tỷ lệ    %)</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;font-weight: bold;">XÁC NHẬN BAN TỔ CHÚC HUYỆN ỦY</th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" style="text-align: center;font-weight: bold;font-size: 14;">TM. BAN THƯỜNG VỤ HUYỆN ĐOÀN</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;"></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" style="text-align: center;font-size: 14;">PHÓ BÍ THƯ PHỤ TRÁCH</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


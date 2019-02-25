
<style>
    p{
        font-family: "Times New Roman" !important;
        text-align: center;
        vertical-align: middle;
    }
    table>thead>th>p{
        font-size: 12pt !important;
    }
    table>tbody>td>p{
        font-size: 12pt !important;
        font-weight: normal !important;
    }
</style>
<div class="col-xs-12">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th scope="col" colspan="5"><p style="font-size: 14pt">TỈNH ĐOÀN BẮC GIANG</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5"><p style="font-size: 14pt">ĐOÀN THANH NIÊN CỘNG SẢN HỒ CHÍ MINH</p></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5"><p style="font-size: 14pt">BCH ĐOÀN {{strtoupper($group_name)}}</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" ></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" ><p style="font-size: 14pt">***</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" ></th>
                    </tr>
                </table>
                <p style="font-size: 14pt">THỐNG KÊ</p>
                <p style="font-size: 14pt">{{$report_name}}</p>
                <p>---------------</p>
                <table class="table table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="width: 30; border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Số thứ tự</p></th>
                        <th scope="col" rowspan="2" style="width: 40; border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Họ tên</p></th>
                        <th scope="col" colspan="2" style="width: 40; border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Ngày, tháng, năm sinh</p></th>
                        <th scope="col" rowspan="2" style="width: 30; border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Dân tộc</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Tôn giáo</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Học vấn</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Chuyên môn</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Chức vụ, nghề nghiệp</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Chi bộ</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Đảng bộ</p></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="1" style="width: 30;font-style: italic;border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Nam</p></th>
                        <th scope="col" colspan="1" style="width: 30;font-style: italic;border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">Nữ</p></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $data = array();
                        $count_level_1 = 0;
                    @endphp
                    @foreach($result as $parent_id => $members)
                        @php
                            $parent = \App\Group::whereId($parent_id)->first();
                            if($parent){
                                $parent_name = $parent->name;
                            } else{
                                $parent_name = '';
                            }
                        @endphp
                        @foreach($members as $group_id => $items)
                            @php
                                $k = 0;
                                $count = count($items);
                            @endphp
                            @foreach($items as $item)
                                @php
                                    $i++;
                                    $k++;
                                    $birthday = Carbon\Carbon::createFromFormat('Y-m-d',$item['birthday']);
                                @endphp
                                <tr>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse; "><p style="font-size: 12pt">{{$i}}.</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  vertical-align: middle;"><p style="text-align: left;font-size: 12pt">{{$item['fullname']}}</p></td>
                                    @if($item['gender'] == 1)
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$birthday->format('d/m/Y')}}</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                    @else
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$birthday->format('d/m/Y')}}</p></td>
                                    @endif
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$item['nation']}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$item['religion']}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">=CONCAT("{{$item['education_level']}}"," / 12")</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$item['knowledge']}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$item['position']}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt">{{$item['group_name']}}</p></td>
                                    @if($k == 1)
                                        <td scope="col" rowspan="{{$count}}" style="border: 1px solid #000000; border-collapse: collapse;  "><p style="font-size: 12pt;vertical-align: top">{{$parent_name}}</p></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
                <p style="font-size: 12pt">* Tổng số đoàn viên ưu tú được kết nạp Đảng/tổng số đảng viên mới kết nạp trong toàn Đảng bộ : {{$i}}/ (Đạt tỷ lệ    %)</p>
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th scope="col" colspan="5" style=" font-weight: bold;"><p style="font-size: 14pt">XÁC NHẬN BAN TỔ CHÚC HUYỆN ỦY</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5"><p style="font-size: 14pt">TM. BAN THƯỜNG VỤ HUYỆN ĐOÀN</p></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" ></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" ><p style="font-size: 14pt">PHÓ BÍ THƯ PHỤ TRÁCH</p></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


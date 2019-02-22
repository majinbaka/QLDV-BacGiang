<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head><meta http-equiv=Content-Type content="text/html; charset=utf-8"><title></title>
    <style>
        v\:* {behavior:url(#default#VML);}
        o\:* {behavior:url(#default#VML);}
        w\:* {behavior:url(#default#VML);}
        .shape {behavior:url(#default#VML);}
    </style>
    <style>
        @page
        {
            mso-page-orientation: landscape;
        }
        @page Section1 {
            mso-header-margin:.5in;
            mso-footer-margin:.5in;
            mso-first-header: fh1;
            mso-header: h1;
            mso-footer: f1;
        }
        div.Section1 { page:Section1; }
        #hrdftrtbl
        {
            width:1px;
            height:1px;
            overflow:hidden;
            
        }
        p.MsoHeader, li.MsoHeader, div.MsoHeader {margin:0in; margin-bottom:-50pt;}
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
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
</head>
<body>
<div class="Section1">
    <div id="hrdftrtbl">
        <div style="mso-element:header;" id="h1">
            <p class=MsoHeader><span class=SpellE></span>  <!--[if supportFields]><span
                        class=MsoPageNumber><span style='mso-element:field-begin'></span><span
                        style='mso-spacerun:yes'> </span>PAGE <span style='mso-element:field-separator'></span></span><![endif]-->
                <!--[if supportFields]><span
                        class=MsoPageNumber><span style='mso-element:field-end'></span></span><![endif]-->
               
            </p>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th scope="col" colspan="5"><p>TỈNH ĐOÀN BẮC GIANG</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5"><p>ĐOÀN THANH NIÊN CỘNG SẢN HỒ CHÍ MINH</p></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" style="color: #ff0000"><p>BCH ĐOÀN {{strtoupper($group_name)}}</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" ></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" ><p>***</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" ></th>
                    </tr>
                </table>
                <p style="font-size: 14px">THỐNG KÊ</p>
                <p style="color: #ff0000;font-size: 14pt">Danh sách đoàn viên được kết nạp năm</p>
                <p >---------------</p>
                <table class="table table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="width: 30; border: 1px solid #000000; border-collapse: collapse; "><p>Số thứ tự</p></th>
                        <th scope="col" rowspan="2" style="width: 40; border: 1px solid #000000; border-collapse: collapse; "><p>Họ tên</p></th>
                        <th scope="col" colspan="2" style="width: 40; border: 1px solid #000000; border-collapse: collapse; "><p>Ngày, tháng, năm sinh</p></th>
                        <th scope="col" rowspan="2" style="width: 30; border: 1px solid #000000; border-collapse: collapse; "><p>Dân tộc</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p>Tôn giáo</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p>Học vấn</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p>Chuyên môn</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p>Chức vụ, nghề nghiệp</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p>Chi bộ</p></th>
                        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; border-collapse: collapse; "><p>Đảng bộ</p></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="1" style="width: 30;font-style: italic;border: 1px solid #000000; border-collapse: collapse; "><p>Nam</p></th>
                        <th scope="col" colspan="1" style="width: 30;font-style: italic;border: 1px solid #000000; border-collapse: collapse; "><p>Nữ</p></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $i = 0;
                        if($ids == ''){
                            $groups = \App\Group::all();
                        } else{
                            $groups = \App\Group::whereIn('id',$ids)->get();
                        }
                        $listGroup = [];
                        foreach ($groups as $group){
                            $listGroup[$group->id] = $group->name;
                        }
                        $data = array();
                        $count_level_1 = 0;
                    @endphp
                    @foreach ($listGroup as $key => $value)
                        @php
                            $data[$key] = 0;
                            $h = 0;
                            $j = 0;
                        @endphp
                        @foreach ($result as $k => $item)
                            @if($item->parent_id == $key)
                                @php $data[$key] +=1; @endphp
                            @endif
                            @if($item->parent_id == 0)
                                @php $count_level_1 +=1; @endphp
                            @endif
                        @endforeach
                        @foreach ($result as $k => $item)
                            @if($item->parent_id == $key)
                                @php
                                    $i++;
                                    $h++;
                                    $birthday = Carbon\Carbon::createFromFormat('Y-m-d',$item->birthday);
                                @endphp
                                <tr>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse; "><p>{{$i}}.</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  vertical-align: middle;"><p style="text-align: left">{{$item->fullname}}</p></td>
                                    @if($item->gender == 1)
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$birthday->format('d/m/Y')}}</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                    @else
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$birthday->format('d/m/Y')}}</p></td>
                                    @endif
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->nation}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->religion}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->education_level}}/12</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->knowledge}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->position}}</p></td>
                                    <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->group_name}}</p></td>
                                    @if($h == 1)
                                        <td scope="col" rowspan="{{$data[$key]}}" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$value}}</p></td>
                                    @endif
                                </tr>
                                @php unset($result[$k]) @endphp
                            @else
                                @if($item->parent_id == 0)
                                    @php
                                        $i++;
                                        $j++;
                                        $birthday = Carbon\Carbon::createFromFormat('Y-m-d',$item->birthday);
                                    @endphp
                                    <tr>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse; "><p>{{$i}}.</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  vertical-align: middle;"><p style="text-align: left">{{$item->fullname}}</p></td>
                                        @if($item->gender == 1)
                                            <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$birthday->format('d/m/Y')}}</p></td>
                                            <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                        @else
                                            <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                            <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$birthday->format('d/m/Y')}}</p></td>
                                        @endif
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->nation}}</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->religion}}</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->education_level}}/12</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->knowledge}}</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->position}}</p></td>
                                        <td scope="col" style="border: 1px solid #000000; border-collapse: collapse;  "><p>{{$item->group_name}}</p></td>
                                        @if($j == 1)
                                            <td scope="col" rowspan="{{$count_level_1}}" style="border: 1px solid #000000; border-collapse: collapse;  "></td>
                                        @endif
                                    </tr>
                                    @php unset($result[$k]) @endphp
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
                <p>* Tổng số đoàn viên ưu tú được kết nạp Đảng/tổng số đảng viên mới kết nạp trong toàn Đảng bộ : {{$i}}/ (Đạt tỷ lệ    %)</p>
                <table class="table table-bordered" style="font-size: 14pt" width="100%">
                    <tr>
                        <th scope="col" colspan="5" style=" font-weight: bold;"><p>XÁC NHẬN BAN TỔ CHÚC HUYỆN ỦY</p></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5"><p>TM. BAN THƯỜNG VỤ HUYỆN ĐOÀN</p></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="5" ></th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="5" ><p>PHÓ BÍ THƯ PHỤ TRÁCH</p></th>

                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>


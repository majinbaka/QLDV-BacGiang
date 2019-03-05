
<style>
    p{
        font-family: "Times New Roman" !important;
        text-align: center;
        vertical-align: middle;
    }
    .table-content>thead>th>p{
        font-size: 12pt !important;
    }
    .table-content>tbody>td>p{
        font-size: 12pt !important;
        font-weight: normal !important;
    }
</style>
<table class="table table-bordered table-content" width="100%" style="border-collapse: collapse">
    <thead>
    <tr>
        <th scope="col" rowspan="2" style="width: 30; border: 1px solid #000000; "><p>Số thứ tự</p></th>
        <th scope="col" rowspan="2" style="width: 40; border: 1px solid #000000; "><p>Họ tên</p></th>
        <th scope="col" colspan="2" style="width: 40; border: 1px solid #000000; "><p>Ngày, tháng, năm sinh</p></th>
        <th scope="col" rowspan="2" style="width: 30; border: 1px solid #000000; "><p>Dân tộc</p></th>
        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; "><p>Tôn giáo</p></th>
        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; "><p>Học vấn</p></th>
        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; "><p>Chuyên môn</p></th>
        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; "><p>Chức vụ, nghề nghiệp</p></th>
        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; "><p>Chi bộ</p></th>
        <th scope="col" rowspan="2" style="width: 40;  border: 1px solid #000000; "><p>Đảng bộ</p></th>
    </tr>
    <tr>
        <th scope="col" colspan="1" style="width: 30;font-style: italic;border: 1px solid #000000; "><p>Nam</p></th>
        <th scope="col" colspan="1" style="width: 30;font-style: italic;border: 1px solid #000000; "><p>Nữ</p></th>
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
                    <td scope="col" style="border: 1px solid #000000; "><p>{{$i}}.</p></td>
                    <td scope="col" style="border: 1px solid #000000;  vertical-align: middle;"><p style="text-align: left">{{$item['fullname']}}</p></td>
                    @if($item['gender'] == 1)
                        <td scope="col" style="border: 1px solid #000000;  "><p>{{$birthday->format('d/m/Y')}}</p></td>
                        <td scope="col" style="border: 1px solid #000000;  "></td>
                    @else
                        <td scope="col" style="border: 1px solid #000000;  "></td>
                        <td scope="col" style="border: 1px solid #000000;  "><p>{{$birthday->format('d/m/Y')}}</p></td>
                    @endif
                    <td scope="col" style="border: 1px solid #000000;  "><p>{{$item['nation']}}</p></td>
                    <td scope="col" style="border: 1px solid #000000;  "><p>{{$item['religion']}}</p></td>
                    <td scope="col" style="border: 1px solid #000000;  "><p>{{$item['education_level']}}/12</p></td>
                    <td scope="col" style="border: 1px solid #000000;  "><p>{{$item['knowledge']}}</p></td>
                    <td scope="col" style="border: 1px solid #000000;  "><p>{{$item['position']}}</p></td>
                    <td scope="col" style="border: 1px solid #000000;  "><p>{{$item['group_name']}}</p></td>
                    @if($k == 1)
                        <td scope="col" rowspan="{{$count}}" style="border: 1px solid #000000;  "><p>{{$parent_name}}</p></td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    @endforeach
            </tbody>
                </table>

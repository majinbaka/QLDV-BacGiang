@extends('layouts.app')
@section('content')
    <style>
        table{
            float: left;
        }
        td{
            height: 30px;
        }
        tr td:first-child{
            font-weight: bold;
        }
        tr td:nth-child(2){
            text-align: right;
            width: 200px;
        }
    </style>
    <table>
        <tr>
            <td>-   Tổng số thanh niên</td>
            <td>@if(isset($result['total_thanhnien'])) {{number_format($result['total_thanhnien'],0,',','.')}} @else  0 @endif</td>
        </tr>
        <tr>
            <td>-   Tổng số đoàn viên</td>
            <td>@if(isset($result['total_doanvien'])) {{number_format($result['total_doanvien'],0,',','.')}} @else  0 @endif</td>
        </tr>
        <tr>
            <td>-   Tổng số huyện, thành đoàn và đoàn trực thuộc</td>
            <td>@if(isset($result['tong_donvi_cap_1'])) {{number_format($result['tong_donvi_cap_1'],0,',','.')}} @else  0 @endif</td>
        </tr>
        <tr>
            <td>-   Tổng số cơ sở Đoàn:</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 20px">+ Đoàn cơ sở:</td>
            <td>@if(isset($result['tong_donvi_cap_2'])) {{number_format($result['tong_donvi_cap_2'],0,',','.')}} @else  0 @endif</td>
        </tr>
        <tr>
            <td style="padding-left: 20px">+ Chi đoàn cơ sở</td>
            <td>@if(isset($result['tong_donvi_cap_3'])) {{number_format($result['tong_donvi_cap_3'],0,',','.')}} @else  0 @endif</td>
        </tr>
        <tr>
            <td>-   Tổng số chi đoàn</td>
            <td></td>
        </tr>
    </table>
@endsection


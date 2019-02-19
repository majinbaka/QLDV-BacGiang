<?php

namespace App\Http\Controllers;

use App\Group;
use App\Knowledge;
use App\Member;
use App\Nation;
use App\Political;
use App\Position;
use App\Religion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Excel;

class ReportController extends Controller
{
    public function index(){
        $groups = Group::all();
        $positions = Position::all();
        $knowledges = Knowledge::all();
        $politicals = Political::all();
        $nations = Nation::all();
        $religions = Religion::all();
        return view('report.index',compact('groups','positions','knowledges','politicals','nations','religions'));
    }

    private function getData($request){
        $group_id = $request->get("child_group_id");
        $position = $request->get("position");
        $term = $request->get("term");
        $gender = $request->get("gender");
        $birthday_from = $request->get("birthday_from");
        $birthday_to = $request->get("birthday_to");
        $join_date_from = $request->get("join_date_from");
        $join_date_to = $request->get("join_date_to");
        $knowledge = $request->get("knowledge");
        $political = $request->get("political");
        $current_district = $request->get("current_district");
        $nation = $request->get("nation");
        $religion = $request->get("religion");
        $relation = $request->get("relation");

        $query = Member::select(DB::raw('members.fullname as fullname,members.gender as gender, members.birthday as birthday, nations.name as nation, religions.name as religion, 
                                                knowledges.name as knowledge, positions.name as position, groups.name as group_name,members.group_id as group_id'))
                        ->leftJoin('nations','members.nation','=','nations.id')
                        ->leftJoin('religions','members.religion','=','religions.id')
                        ->leftJoin('knowledges','members.knowledge','=','knowledges.id')
                        ->leftJoin('positions','members.position','=','positions.id')
                        ->leftJoin('groups','members.group_id','=','groups.id');
        if($group_id){
            $query->where('members.group_id','=',$group_id);
        }
        if($position){
            $query->where('members.position','=',$position);
        }
        if($term){
            $query->where('members.term','like','"%'.$term.'%"');
        }
        if($gender){
            $query->where('members.gender','=',$gender);
        }
        if($birthday_from){
            $query->where('members.birthday','>=',$birthday_from);
        }
        if($birthday_to){
            $query->where('members.birthday','<=',$birthday_to);
        }
        if($join_date_from){
            $query->where('members.join_date','>=',$join_date_from);
        }
        if($join_date_to){
            $query->where('members.join_date','<=',$join_date_to);
        }
        if($knowledge){
            $query->where('members.knowledge','=',$knowledge);
        }
        if($political){
            $query->where('members.political','=',$political);
        }
        if($current_district){
            $query->where('members.current_district','like','"%'.$current_district.'%"');
        }
        if($nation){
            $query->where('members.nation','=',$nation);
        }
        if($religion){
            $query->where('members.religion','=',$religion);
        }
        if($relation){
            $query->where('members.relation','=',$relation);
        }
        $members = $query->get();
        return $members;
    }

    public function exportToWord(Request $request)
    {
        $data = $this->getData($request);
        $report_name = $request->get("report_name");
        $group_name = $request->get("group_name");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection(array('orientation'=>'landscape'));

        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        //header
        $tableTop = $section->addTable();
        $tableTop->addRow();
        $tableTop->addCell('6000')->addText('TỈNH ĐOÀN BẮC GIANG',array('size'=>14,'name'=>'Time New Roman'),$cellHCentered);
        $tableTop->addCell('8000')->addText('ĐOÀN THANH NIÊN CỘNG SẢN HỒ CHÍ MINH',array('size'=>14,'bold'=>true,'name'=>'Time New Roman','underline'=>\PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE),$cellHCentered);

        $tableTop->addRow();
        $tableTop->addCell('6000')->addText('BCH ĐOÀN '.$group_name,array('size'=>14,'color'=>'ff0000','name'=>'Time New Roman'),$cellHCentered);
        $tableTop->addCell('8000')->addText('');

        $tableTop->addRow();
        $tableTop->addCell('6000')->addText('***',array('size'=>14,'bold'=>true,'name'=>'Time New Roman'),$cellHCentered);
        $tableTop->addCell('8000')->addText('');

        $header = array('size' => 14, 'bold' => true,'name'=>'Time New Roman');
        $header1 = array('size' => 14, 'bold' => true,'color'=>'ff0000','name'=>'Time New Roman');
        $section->addText('THỐNG KÊ', $header,$cellHCentered);
        $section->addText('Danh sách đoàn viên được kết nạp năm ', $header1,$cellHCentered);
        $section->addText('----------------', null,$cellHCentered);
        $section->addText('', null,$cellHCentered);

        //table
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');

        $cellVCentered = array('valign' => 'center');
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);
        $rowTitleFontStyle = array('size' => 12, 'bold' => true,'name'=>'Time New Roman');
        $rowSubTitleFontStyle = array('size'=>12, 'bold'=>true, 'italic'=>true,'name'=>'Time New Roman');
        $table->addRow();
        $table->addCell(2500, $cellRowSpan)->addText('Số thứ tự', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(4000, $cellRowSpan)->addText('Họ tên', $rowTitleFontStyle, $cellHCentered);
        $cell2 = $table->addCell(5000, $cellColSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Ngày, tháng, năm sinh',$rowTitleFontStyle);
        $table->addCell(1000, $cellRowSpan)->addText('Dân tộc', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(1000, $cellRowSpan)->addText('Tôn giáo', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(1000, $cellRowSpan)->addText('Học vấn', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(1000, $cellRowSpan)->addText('Chuyên môn', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(6000, $cellRowSpan)->addText('Chức vụ, nghề nghiệp', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(6000, $cellRowSpan)->addText('Chi bộ', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(6000, $cellRowSpan)->addText('Đảng bộ', $rowTitleFontStyle, $cellHCentered);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellVCentered)->addText('Nam', $rowSubTitleFontStyle, $cellHCentered);
        $table->addCell(2000, $cellVCentered)->addText('Nữ', $rowSubTitleFontStyle, $cellHCentered);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $i = 0;
        $cellFontStyle = array('size'=>12,'name'=>'Time New Roman');
        foreach ($data as $item) {
            $i++;
            $table->addRow();
            $table->addCell(2000,$cellVCentered)->addText($i,$cellFontStyle);
            $table->addCell(4000,$cellVCentered)->addText($item->fullname,$cellFontStyle);
            $birthday = Carbon::createFromFormat('Y-m-d',$item->birthday);
            if($item->gender == 1){
                $table->addCell(2500,$cellVCentered)->addText($birthday->format('d/m/Y'),$cellFontStyle);
                $table->addCell(2500,$cellVCentered)->addText('',$cellFontStyle);
            } else{
                $table->addCell(2500,$cellVCentered)->addText('',$cellFontStyle);
                $table->addCell(2500,$cellVCentered)->addText($birthday->format('d/m/Y'),$cellFontStyle);
            }
            $table->addCell(1000,$cellVCentered)->addText($item->nation,$cellFontStyle);
            $table->addCell(1000,$cellVCentered)->addText($item->religion,$cellFontStyle);
            $table->addCell(1000,$cellVCentered)->addText('',$cellFontStyle);
            $table->addCell(1000,$cellVCentered)->addText($item->knowledge,$cellFontStyle);
            $table->addCell(6000,$cellVCentered)->addText($item->position,$cellFontStyle);
            $table->addCell(6000,$cellVCentered)->addText($item->group_name,$cellFontStyle);
            $table->addCell(6000,$cellVCentered)->addText($item->group_name,$cellFontStyle);
        }
        $section->addText('');
        $section->addText('* Tổng số đoàn viên ưu tú được kết nạp Đảng/tổng số đảng viên mới kết nạp trong toàn Đảng bộ : '.$i.'/173 (Đạt tỷ lệ 80,3%)');
        $tableBot = $section->addTable();
        $tableBot->addRow();
        $tableBot->addCell('6000')->addText('XÁC NHẬN BAN TỔ CHỨC HUYỆN ỦY',$header,$cellHCentered);
        $tableBot->addCell('8000')->addText('TM. BAN THƯỜNG VỤ HUYỆN ĐOÀN',$header,$cellHCentered);

        $tableBot->addRow();
        $tableBot->addCell('6000')->addText('',$header,$cellHCentered);
        $tableBot->addCell('8000')->addText('PHÓ BÍ THƯ PHỤ TRÁCH',array('size'=>14),$cellHCentered);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(public_path('export/word/'.$report_name.'.doc'));
        return $report_name;
    }

//    public function exportToExcel(Request $request){
//        $report_name = $request->get("report_name");
//        Excel::create($report_name, function ($excel) use ($request) {
//            $excel->sheet('Sheet 1', function ($sheet) use ($request){
//                $data = $this->getData($request);
//                $group_name = $request->get("group_name");
//                $sheet->loadView('export.index')->with(['result'=>$data,'group_name'=>$group_name]);
//            })->store('xls',public_path());
//        });
//    }
}
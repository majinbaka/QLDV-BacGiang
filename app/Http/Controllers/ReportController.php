<?php

namespace App\Http\Controllers;

use App\Group;
use App\Knowledge;
use App\Member;
use App\Nation;
use App\Political;
use App\Position;
use App\Religion;
use Illuminate\Http\Request;

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

        $query = Member::select();
        if($group_id){
            $query->where('group_id','=',$group_id);
        }
        if($position){
            $query->where('position','=',$position);
        }
        if($term){
            $query->where('term','like','"%'.$term.'%"');
        }
        if($gender){
            $query->where('gender','=',$gender);
        }
        if($birthday_from){
            $query->where('birthday','>=',$birthday_from);
        }
        if($birthday_to){
            $query->where('birthday','<=',$birthday_to);
        }
        if($join_date_from){
            $query->where('join_date','>=',$join_date_from);
        }
        if($join_date_to){
            $query->where('join_date','<=',$join_date_to);
        }
        if($knowledge){
            $query->where('knowledge','=',$knowledge);
        }
        if($political){
            $query->where('political','=',$political);
        }
        if($current_district){
            $query->where('current_district','like','"%'.$current_district.'%"');
        }
        if($nation){
            $query->where('nation','=',$nation);
        }
        if($religion){
            $query->where('religion','=',$religion);
        }
        if($relation){
            $query->where('relation','=',$relation);
        }
        $members = $query->get();

        return $members;
    }
    public function exportToWord(Request $request)
    {
        $data = $this->getData($request);
        $report_name = $request->get("report_name");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

        $section->addTextBreak(1);
        $section->addText($report_name, $header);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Mã đoàn viên', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Họ tên', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Chức vụ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Giới tính', $fancyTableFontStyle);
        $table->addCell(1000, $fancyTableCellBtlrStyle)->addText('Ngày sinh', $fancyTableFontStyle);
        foreach ($data as $item) {
            $table->addRow();
            $table->addCell(2000)->addText($item->uuid);
            $table->addCell(2000)->addText($item->fullname);
            $table->addCell(2000)->addText($item->position);
            $table->addCell(2000)->addText($item->gender);
            $table->addCell(500)->addText($item->birthday);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Appdividend.docx');
        $path = public_path('Appdividend.docx');
        return $path;
    }
}

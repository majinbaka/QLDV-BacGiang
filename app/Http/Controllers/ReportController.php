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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $groups = Group::all();
        } else{
            $group = $user->group;
            $ids = $group->getIdsG();
            $groups = Group::whereIn('id', $ids)->get();
        }

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

        $query = Member::select(DB::raw('members.fullname as fullname,members.gender as gender, members.birthday as birthday, 
                                                members.nation_text as nation, members.position_text as position,
                                                members.knowledge_text as knowledge, members.political_text as political,
                                                members.religion_text as religion,
                                                groups.name as group_name,members.group_id as group_id,members.education_level as education_level,
                                                groups.parent_id as parent_id,groups.level as level'))
            ->leftJoin('groups','members.group_id','=','groups.id');
        if($group_id){
            $group = Group::where('id',$group_id)->first();
            $ids = $group->getIdsG();
            $query->whereIn('members.group_id',$ids);
        } else{
            $ids = '';
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
        $members = $query->orderBy('parent_id','DESC')->orderBy('level','ASC')->get();
//        $data = $this->groupData($members);
        $data = [
            'members'=>$members,
            'group_ids'=>$ids
        ];
        return $data;
    }

    private function groupData($members){
        $result = array();
        foreach ($members as $member){
            if(array_key_exists($member->parent_id,$result)){
                if(array_key_exists($member->group_id,$result[$member->parent_id])){
                    $result[$member->parent_id][$member->group_id][]= $member->toArray();
                } else{
                    $result[$member->parent_id][$member->group_id] = [$member->toArray()];
                }
            } else{
                $result[$member->parent_id] = [$member->group_id => [$member->toArray()]];
            }
        }
        return $result;
    }
    public function exportToWord(Request $request)
    {
        $data = $this->getData($request);
        $result = $data['members'];
        $ids = $data['group_ids'];
        if($ids == ''){
            $groups = Group::all();
        } else{
            $groups = Group::whereIn('id',$ids)->get();
        }

        $listGroup = [];
        foreach ($groups as $group){
            $listGroup[$group->id] = $group->name;
        }
        $report_name = $request->get("report_name");
        $group_name = $request->get("group_name");
        return view('export.word',compact('result','ids','report_name','group_name'));
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection(array('orientation'=>'landscape'));

        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        //header
        $tableTop = $section->addTable();
        $tableTop->addRow();
        $tableTop->addCell('6000')->addText('TỈNH ĐOÀN BẮC GIANG',array('size'=>14,'name'=>'Times New Roman'),$cellHCentered);
        $tableTop->addCell('8000')->addText('ĐOÀN THANH NIÊN CỘNG SẢN HỒ CHÍ MINH',array('size'=>14,'bold'=>true,'name'=>'Times New Roman','underline'=>\PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE),$cellHCentered);

        $tableTop->addRow();
        $tableTop->addCell('6000')->addText(strtoupper($group_name),array('size'=>14,'color'=>'ff0000','name'=>'Times New Roman'),$cellHCentered);
        $tableTop->addCell('8000')->addText('');

        $tableTop->addRow();
        $tableTop->addCell('6000')->addText('***',array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),$cellHCentered);
        $tableTop->addCell('8000')->addText('');

        $header = array('size' => 14, 'bold' => true,'name'=>'Times New Roman');
        $header1 = array('size' => 14, 'bold' => true,'color'=>'ff0000','name'=>'Times New Roman');
        $section->addText('THỐNG KÊ', $header,$cellHCentered);
        $section->addText($report_name, $header1,$cellHCentered);
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
        $rowTitleFontStyle = array('size' => 12, 'bold' => true,'name'=>'Times New Roman');
        $rowSubTitleFontStyle = array('size'=>12, 'bold'=>true, 'italic'=>true,'name'=>'Times New Roman');
        $table->addRow();
        $table->addCell(2500, $cellRowSpan)->addText('Số thứ tự', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(4000, $cellRowSpan)->addText('Họ tên', $rowTitleFontStyle, $cellHCentered);
        $cell2 = $table->addCell(5000, $cellColSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Ngày, tháng, năm sinh',$rowTitleFontStyle);
        $table->addCell(1000, $cellRowSpan)->addText('Dân tộc', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(1000, $cellRowSpan)->addText('Tôn giáo', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(1000, $cellRowSpan)->addText('Học vấn', $rowTitleFontStyle, $cellHCentered);
        $table->addCell(2000, $cellRowSpan)->addText('Chuyên môn', $rowTitleFontStyle, $cellHCentered);
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
        $cellFontStyle = array('size'=>12,'name'=>'Times New Roman','valign'=>'center');
        foreach ($listGroup as $key => $value){
            $h = 0;
            $j = 0;
            foreach ($members as $k => $item){
                $chk = false;
                if($item->parent_id == $key){
                    $chk = true;
                    $i++;
                    $h++;
                } else {
                    if ($item->parent_id == 0){
                        $chk = true;
                        $i++;
                        $j++;
                    }
                }
                if($chk){
                    $table->addRow();
                    $table->addCell(2000,$cellVCentered)->addText($i.'.',$cellFontStyle,$cellHCentered);
                    $table->addCell(4000,$cellVCentered)->addText($item->fullname,$cellFontStyle);
                    $birthday = Carbon::createFromFormat('Y-m-d',$item->birthday);
                    if($item->gender == 1){
                        $table->addCell(2500,$cellVCentered)->addText($birthday->format('d/m/Y'),$cellFontStyle,$cellHCentered);
                        $table->addCell(2500,$cellVCentered)->addText('',$cellFontStyle,$cellHCentered);
                    } else{
                        $table->addCell(2500,$cellVCentered)->addText('',$cellFontStyle,$cellHCentered);
                        $table->addCell(2500,$cellVCentered)->addText($birthday->format('d/m/Y'),$cellFontStyle,$cellHCentered);
                    }
                    $table->addCell(1000,$cellVCentered)->addText($item->nation,$cellFontStyle,$cellHCentered);
                    $table->addCell(1000,$cellVCentered)->addText($item->religion,$cellFontStyle,$cellHCentered);
                    $table->addCell(1000,$cellVCentered)->addText($item->education_level.'/12',$cellFontStyle,$cellHCentered);
                    $table->addCell(2000,$cellVCentered)->addText($item->knowledge,$cellFontStyle,$cellHCentered);
                    $table->addCell(6000,$cellVCentered)->addText($item->position,$cellFontStyle,$cellHCentered);
                    $table->addCell(6000,$cellVCentered)->addText($item->group_name,$cellFontStyle,$cellHCentered);
                    if($h == 1){
                        $table->addCell(6000,$cellRowSpan)->addText($value,$cellFontStyle,$cellHCentered);
                    }
                    if($j == 1){
                        $table->addCell(6000,$cellRowSpan)->addText('',$cellFontStyle,$cellHCentered);
                    }
                    $table->addCell(null, $cellRowContinue);
                    unset($members[$k]);
                }
            }
        }
        $section->addText('');
        $section->addText('* Tổng số đoàn viên ưu tú được kết nạp Đảng/tổng số đảng viên mới kết nạp trong toàn Đảng bộ : '.$i.'/ (Đạt tỷ lệ    %)');
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

    public function exportToExcel(Request $request){
        $report_name = $request->get("report_name");
        Excel::create($report_name, function ($excel) use ($request) {
            $excel->sheet('Sheet 1', function ($sheet) use ($request){
                $data = $this->getData($request);

                $group_name = $request->get("group_name");
                $sheet->loadView('export.index')->with(['result'=>$data['members'],'group_name'=>$group_name,'ids'=>$data['group_ids']]);
                $sheet->setFontFamily('Times New Roman');
                $sheet->cells('A1:G3', function($cells) {

                    $cells->setFontSize(14);

                });
            })->store('xlsx',public_path('export/excel/'));
        });
    }
}

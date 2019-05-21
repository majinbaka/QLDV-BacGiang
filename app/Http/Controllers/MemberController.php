<?php

namespace App\Http\Controllers;

use App\BlockMember;
use function foo\func;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Member;
use App\Group;
use App\ItLevel;
use App\EnglishLevel;
use App\Knowledge;
use App\Political;
use App\Position;
use App\Attachment;
use App\Nation;
use App\Religion;
use Exception;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function search(){
        $user = Auth::user();
        $code = request()->get('code');
        $fullname = request()->get('fullname');
        if(request()->get('group')){
            $uuid = request()->get('group');
        } else{
            $uuid = null;
        }

        $page = \request()->get('page');
        if($fullname != session()->get('fullname') || $code != session()->get('code') || $uuid != session()->get('group_uuid')){
            $page = 1;
        }
        session()->put('fullname',$fullname);
        session()->put('code',$code);
        session()->put('current_page',$page);
        session()->put('group_uuid',$uuid);
        if ($user->isAn('admin')){
            $groups = Group::where('level', 1)->get();
            $members = Member::select(['code', 'fullname', 'group_id', 'position','uuid']);

            if ($code !== null)
                $members = $members->where('code','like', '%'.$code.'%');
            if ($fullname !== null){
                $ascii_fullname = $this->unicode_to_ascii($fullname);
                $members = $members->where('fullname','like', '%'.$fullname.'%')->orWhere('ascii_fullname','like', '%'.$ascii_fullname.'%');
            }

            if ($uuid !== null){
                $group = Group::where('uuid', $uuid)->first();
                if ($group !== null){
                    $ids = $group->getIdsG();
                    $members = $members->whereIn('group_id', $ids);
                }
                $groupId = $group->id;
            } else{
                $groupId = 0;
            }
            $memberc = $members->count();
            $members = $members->paginate(20)->setPageName($page);
            return view('home')
                ->with('code', $code)
                ->with('fullname', $fullname)
                ->with('groupId', $groupId)
                ->with('members', $members)
                ->with('groups', $groups)
                ->with('memberc', $memberc)
                ->withSuccess(session()->get( 'success' ));
        }
        else{
            $user_group = $user->group_id;
            $group = Group::where('uuid', $uuid)->first();
            if ($group){
                $has = $group->hasRelation($user_group);
                if (!$has)
                    return \redirect()->route('home')->withErrors(['Không có quyền truy cập đơn vị này']);
            }
            else{
                $group = $user->group;
            }
    
            $ids = $group->getIdsG();
            $groups = Group::where('level', $user->group->level + 1)->where('parent_id', $user->group->id)->get();

            $members = Member::select(['code', 'fullname', 'group_id', 'position','uuid']);
            if ($code !== null)
                $members = $members->where('code','like', '%'.$code.'%');
            if ($fullname !== null)
                $members = $members->where('fullname','like', '%'.$fullname.'%');
            $members = $members->whereIn('group_id', $ids);

            $memberc = $members->count();
            $members = $members->paginate(20)->setPageName($page);
            $groupId = $user->group->id;
            return view('home')
                ->with('code', $code)
                ->with('fullname', $fullname)
                ->with('group', $group)
                ->with('members', $members)
                ->with('groups', $groups)
                ->with('memberc', $memberc)
                ->with('page',$page)
                ->with('groupId',$groupId)
                ->withSuccess(session()->get( 'success' ));
        }
    }

    public function create(){
        $user = Auth::user();
        $its = ItLevel::all();
        $englishs = EnglishLevel::all();
        $knowledges = Knowledge::all();
        $politicals = Political::all();
        $positions = Position::all();
        $nations = Nation::all();
        $religions = Religion::all();
        $blockMembers = BlockMember::all();
        if ($user->isAn('admin')){
            $groups = Group::all();

            return view('members.create', compact('its', 'englishs', 'knowledges', 'politicals', 'positions', 'groups', 'nations', 'religions','blockMembers'));
        }else
        {
            $group = $user->group;
            $ids = $group->getIdsG();
            $groups = Group::whereIn('id', $ids)->get();

            return view('members.create', compact('its', 'englishs', 'knowledges', 'politicals', 'positions', 'groups', 'nations', 'religions','blockMembers'));
        }
    }

    public function edit($uuid){
        $user = Auth::user();
        $member = Member::where('uuid', $uuid)->first();
        $its = ItLevel::all();
        $englishs = EnglishLevel::all();
        $knowledges = Knowledge::all();
        $politicals = Political::all();
        $positions = Position::all();
        $nations = Nation::all();
        $religions = Religion::all();
        $blockMembers = BlockMember::all();
        if ($user->isAn('admin')){
            $groups = Group::all();

            return view('members.edit', compact('its', 'englishs', 'knowledges', 'politicals', 'positions', 'groups', 'member', 'nations', 'religions','blockMembers'))
        ->withSuccess(session()->get( 'success' ));
        }else
        {
            $group = $user->group;
            $ids = $group->getIdsG();
            if (!in_array($member->group_id, $ids)){
                return \redirect()->route('home')->withErrors(['Không có quyền truy cập đoàn viên này']);
            }
            $groups = Group::whereIn('id', $ids)->get();

            return view('members.edit', compact('its', 'englishs', 'knowledges', 'politicals', 'positions', 'groups', 'member', 'nations', 'religions','blockMembers'))
        ->withSuccess(session()->get( 'success' ));
        }
        
    }

    private function unicode_to_ascii($str)
    {
        $asciiUnicodeMap = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($asciiUnicodeMap as $ascii => $uni) {
            $str = preg_replace("/($uni)/i", $ascii, $str);
        }
        return $str;
    }

    public function store(){
        $validator = Validator::make(request()->all(), [
            'fullname' => 'required',
            'code' => 'required|digits:7|unique:members,code',
            'birthday' => 'required|date_format:d/m/Y',
            'gender' => 'digits_between:1,2',
            'position' => 'exists:positions,id',
            'group_id' => 'required',
            'religion' => 'required',
            'nation' => 'required',
            'relation' => 'required',
            'join_date' => 'required|date_format:d/m/Y',
            'city' => 'required',
            'vilage' => 'required',
            'current_city' => 'required',
            'current_vilage' => 'required',
            'knowledge' => 'exists:knowledges,id',
            'political' => 'exists:politicals,id',
            'it_level' => 'exists:it_levels,id',
            'english_level' => 'exists:english_levels,id',
            'is_dangvien' => 'digits_between:0,1',
            'join_dang' => 'date_format:d/m/Y|nullable',
            'avatar' => 'image',
            'block_member_id'=>'exists:block_members,id',
            'education_level' => 'required',
            'manage_object' => 'required|in:0,1,2'
        ],
        [
            'fullname.required' => 'Chưa nhập họ và tên đoàn viên',
            'code.required' => 'Chưa điền mã đoàn viên',
            'code.unique' => 'Mã đoàn viên đã tồn tại',
            'code.digits' => 'Mã đoàn viên phải gồm 7 chữ số',
            'birthday.required' => 'Chưa nhập ngày sinh',
            'birthday.date_format' => 'Ngày sinh định dạng không hợp lệ',
            'gender.digits_between' => 'Giới tính không xác định',
            'position.exists' => 'Chức vụ không hợp lệ',
            'group_id.required' => 'Chưa chọn đơn vị',
            'religion.required' => 'Chưa điền tôn giáo của đoàn viên',
            'nation.required' => 'Chưa điền dân tộc của đoàn viên',
            'relation.required' => 'Chưa điền tình trạng hôn nhân của đoàn viên',
            'join_date.required' => 'Chưa điền ngày vào đoàn',
            'join_date.date_format' => 'Ngày vào đoàn chưa đúng định dạng',
            'city.required' => 'Chưa điền thành phố quê quán',
            'vilage.required' => 'Chưa điền quê quán',
            'current_city.required' => 'Chưa điền thành phố nơi ở hiện tại',
            'current_vilage.required' => 'Chưa điền nơi ở hiện tại',
            'knowledge.exists' => 'Trình độ chưa chính xác',
            'political.exists' => 'Chính trị chưa chính xác',
            'it_level.exists' => 'Tin học chưa chính xác',
            'english_level.exists' => 'Ngoại ngữ chưa chính xác',
            'is_dangvien.digits_between' => 'không xác định được có phải là đảng viên hay không',
            'join_dang.date_format' => 'Ngày vào đảng chưa đúng định dạng',
            'avatar.image' => 'Ảnh đại diện chưa đúng định dạng',
            'block_member_id.exists' => 'Khối đối tượng đoàn viên không hợp lệ',
            'education_level.required' => 'Chưa chọn trình độ học vấn',
            'manage_object.required' => 'Chưa chọn đối tượng quản lý',
            'manage_object.in' => 'Đối tượng quản lý không hợp lệ'
        ]
        );

        if ($validator->fails()) {
            return redirect('member/create')
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $parent_group = Group::where('uuid', request()->get('group_id'))->first();
            if(!$parent_group){
                return redirect()->route('member.create')->withErrors(['Đơn vị không tồn tại'])->withInput();
            }
            $group_id = $parent_group->id;

            $member = new Member;
            $member->uuid = Str::uuid();
            $member->fullname = \request()->get('fullname');
            $member->ascii_fullname = $this->unicode_to_ascii(\request()->get('fullname'));
            $member->code = \request()->get('code');
            $member->birthday = Carbon::createFromFormat('d/m/Y', request()->get('birthday'))->toDateString();
            $member->gender = \request()->get('gender');
            $member->position = \request()->get('position');
            $member->group_id = $group_id;
            $member->religion = \request()->get('religion');
            $member->nation = \request()->get('nation');
            $member->relation = \request()->get('relation');
            $member->join_date = Carbon::createFromFormat('d/m/Y', request()->get('join_date'))->toDateString();
            $member->city = \request()->get('city');
            $member->district = \request()->get('district');
            $member->commune = \request()->get('commune');
            $member->vilage = \request()->get('vilage');
            $member->current_city = \request()->get('current_city');
            $member->current_district = \request()->get('current_district');
            $member->current_commune = \request()->get('current_commune');
            $member->current_vilage = \request()->get('current_vilage');
            $member->knowledge = \request()->get('knowledge');
            $member->political = \request()->get('political');
            $member->it_level = \request()->get('it_level');
            $member->english_level = \request()->get('english_level');
            $member->is_dangvien = \request()->get('is_dangvien');
            if(request()->get('join_dang')){
                $member->join_dang = Carbon::createFromFormat('d/m/Y', request()->get('join_dang'))->toDateString();
            }
            $member->block_member_id = \request()->get('block_member_id');
            $member->education_level = \request()->get('education_level');

            $member->position_text = Position::find(request()->get('position'))->name;
            $member->knowledge_text = Knowledge::find(request()->get('knowledge'))->name;
            $member->political_text = Political::find(request()->get('knowledge'))->name;
            $member->it_text = ItLevel::find(request()->get('it_level'))->name;
            $member->english_text = EnglishLevel::find(request()->get('english_level'))->name;
            $member->nation_text = Nation::find(request()->get('knowledge'))->name;
            $member->religion_text = Religion::find(request()->get('knowledge'))->name;
            $member->blockmember_text = BlockMember::find(request()->get('block_member_id'))->name;
            $member->manage_object = \request()->get('manage_object');

            $member->is_join_maturity_ceremony = \request()->get('is_join_maturity_ceremony');
            $member->from_place = \request()->get('from_place');
            $member->from_reason = \request()->get('from_reason');
            if(request()->get('from_date')){
                $member->from_date = Carbon::createFromFormat('d/m/Y', request()->get('from_date'))->toDateString();
            }

            $member->to_place = \request()->get('to_place');
            $member->to_reason = \request()->get('to_reason');
            if(request()->get('to_date')){
                $member->to_date = Carbon::createFromFormat('d/m/Y', request()->get('to_date'))->toDateString();
            }
            $member->is_go_far_away = \request()->get('is_go_far_away');
            $member->delete_reason = \request()->get('delete_reason');
            $member->rating = \request()->get('rating');
            $member->rating_year = \request()->get('rating_year');
            $member->year_of_maturity_ceremony = \request()->get('year_of_maturity_ceremony');
            $member->is_deleted = \request()->get('is_deleted');
            $member->reason_for_go_away = \request()->get('reason_for_go_away');
            $member->save();

            if (request()->has('avatar'))
            {
                $extension = request()->file('avatar')->extension();
                $avatar = request()->file('avatar')->storeAs(
                    'public/avatars', $member->id.'.'.$extension
                );
                $member->avatar = $avatar;
                $member->save();
            }

            //Attachment
            if(request()->has('attachment') ){
                $attachments = request()->file('attachment') ;
                foreach ($attachments as $v) {
                    $extension = $v->extension();
                    $attachment = new Attachment;
                    $attachment->name = $v->getClientOriginalName();
                    $attachment->member_id = $member->id;
                    $attachment->attachment_url = 'xxx';
                    $attachment->save();
                    $path = $v->storeAs(
                        'public/attachment', $attachment->id.'.'.$extension
                    );
                    $attachment->attachment_url = $path;
                    $attachment->save();
                }
            }
            return \redirect()->route('member.edit', ['uuid' => $member->uuid])->withSuccess('Tạo thông tin thành công');
        } catch(Exception $e){
            return redirect('member/create')->withErrors(['Có lỗi xẩy ra']);
        }
    }

    public function update($uuid){
        $user = Auth::user();
        $member = Member::where('uuid', $uuid)->first();
        if(!$member)
            return redirect()->route('home')
                ->withErrors('Đoàn viên không tồn tại');
        $validator = Validator::make(request()->all(), [
            'fullname' => 'required',
            'code' => 'required|digits:7|unique:members,code,'.$member->id,
            'birthday' => 'required|date_format:d/m/Y',
            'gender' => 'digits_between:1,2',
            'position' => 'exists:positions,id',
            'group_id' => 'required',
            'religion' => 'required',
            'nation' => 'required',
            'relation' => 'required',
            'join_date' => 'required|date_format:d/m/Y',
            'city' => 'required',
            'vilage' => 'required',
            'current_city' => 'required',
            'current_vilage' => 'required',
            'knowledge' => 'exists:knowledges,id',
            'political' => 'exists:politicals,id',
            'it_level' => 'exists:it_levels,id',
            'english_level' => 'exists:english_levels,id',
            'is_dangvien' => 'digits_between:0,1',
            'join_dang' => 'date_format:d/m/Y|nullable',
            'avatar' => 'image',
            'block_member_id' => 'exists:block_members,id',
            'education_level' => 'required',
            'manage_object' => 'required|in:0,1,2'
        ],
        [
            'fullname.required' => 'Chưa nhập họ và tên đoàn viên',
            'code.required' => 'Chưa điền mã đoàn viên',
            'code.unique' => 'Mã đoàn viên đã tồn tại',
            'code.digits' => 'Mã đoàn viên phải gồm 7 chữ số',
            'birthday.required' => 'Chưa nhập ngày sinh',
            'birthday.date_format' => 'Ngày sinh định dạng không hợp lệ',
            'gender.digits_between' => 'Giới tính không xác định',
            'position.exists' => 'Chức vụ không hợp lệ',
            'group_id.required' => 'Chưa chọn đơn vị',
            'religion.required' => 'Chưa điền tôn giáo của đoàn viên',
            'nation.required' => 'Chưa điền dân tộc của đoàn viên',
            'relation.required' => 'Chưa điền tình trạng hôn nhân của đoàn viên',
            'join_date.required' => 'Chưa điền ngày vào đoàn',
            'join_date.date_format' => 'Ngày vào đoàn chưa đúng định dạng',
            'city.required' => 'Chưa điền thành phố quê quán',
            'vilage.required' => 'Chưa điền quê quán',
            'current_city.required' => 'Chưa điền thành phố nơi ở hiện tại',
            'current_vilage.required' => 'Chưa điền nơi ở hiện tại',
            'knowledge.exists' => 'Trình độ chưa chính xác',
            'political.exists' => 'Chính trị chưa chính xác',
            'it_level.exists' => 'Tin học chưa chính xác',
            'english_level.exists' => 'Ngoại ngữ chưa chính xác',
            'is_dangvien.digits_between' => 'không xác định được có phải là đảng viên hay không',
            'join_dang.date_format' => 'Ngày vào đảng chưa đúng định dạng',
            'avatar.image' => 'Ảnh đại diện chưa đúng định dạng',
            'block_member_id.exists' => 'Khối đối tượng đoàn viên không hợp lệ',
            'education_level.required' => 'Chưa chọn trình độ học vấn',
            'manage_object.required' => 'Chưa chọn đối tượng quản lý',
            'manage_object.in' => 'Đối tượng quản lý không hợp lệ'
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        try{
            $parent_group = Group::where('uuid', request()->get('group_id'))->first();
            if(!$parent_group){
                return redirect()->route('member.create')->withErrors(['Đơn vị không tồn tại']);
            }
            $group_id = $parent_group->id;
            if (request()->has('avatar'))
            {
                $extension = request()->file('avatar')->extension();
                $avatar = request()->file('avatar')->storeAs(
                    'public/avatars', $member->id.'.'.$extension
                );
                $member->avatar = $avatar;
            }
            $member->fullname = \request()->get('fullname');
            $member->ascii_fullname = $this->unicode_to_ascii(\request()->get('fullname'));
            $member->code = \request()->get('code');
            $member->birthday = Carbon::createFromFormat('d/m/Y', request()->get('birthday'))->toDateString();
            $member->gender = \request()->get('gender');
            $member->position = \request()->get('position');
            $member->group_id = $group_id;
            $member->religion = \request()->get('religion');
            $member->nation = \request()->get('nation');
            $member->relation = \request()->get('relation');
            $member->join_date = Carbon::createFromFormat('d/m/Y', request()->get('join_date'))->toDateString();
            $member->city = \request()->get('city');
            $member->district = \request()->get('district');
            $member->commune = \request()->get('commune');
            $member->vilage = \request()->get('vilage');
            $member->current_city = \request()->get('current_city');
            $member->current_district = \request()->get('current_district');
            $member->current_commune = \request()->get('current_commune');
            $member->current_vilage = \request()->get('current_vilage');
            $member->knowledge = \request()->get('knowledge');
            $member->political = \request()->get('political');
            $member->it_level = \request()->get('it_level');
            $member->english_level = \request()->get('english_level');
            $member->is_dangvien = \request()->get('is_dangvien');
            if(\request()->get('join_dang')){
                $member->join_dang = Carbon::createFromFormat('d/m/Y', request()->get('join_dang'))->toDateString();
            }

            $member->block_member_id = \request()->get('block_member_id');
            $member->education_level = \request()->get('education_level');
            $member->position_text = Position::find(request()->get('position'))->name;
            $member->knowledge_text = Knowledge::find(request()->get('knowledge'))->name;
            $member->political_text = Political::find(request()->get('knowledge'))->name;
            $member->it_text = ItLevel::find(request()->get('it_level'))->name;
            $member->english_text = EnglishLevel::find(request()->get('english_level'))->name;
            $member->nation_text = Nation::find(request()->get('knowledge'))->name;
            $member->religion_text = Religion::find(request()->get('knowledge'))->name;
            $member->blockmember_text = BlockMember::find(request()->get('block_member_id'))->name;

            $member->manage_object = \request()->get('manage_object');

            $member->is_join_maturity_ceremony = \request()->get('is_join_maturity_ceremony');
            $member->from_place = \request()->get('from_place');
            $member->from_reason = \request()->get('from_reason');
            if(request()->get('from_date')){
                $member->from_date = Carbon::createFromFormat('d/m/Y', request()->get('from_date'))->toDateString();
            }
            $member->to_place = \request()->get('to_place');
            $member->to_reason = \request()->get('to_reason');
            if(request()->get('to_date')){
                $member->to_date = Carbon::createFromFormat('d/m/Y', request()->get('to_date'))->toDateString();
            }
            $member->is_go_far_away = \request()->get('is_go_far_away');
            $member->delete_reason = \request()->get('delete_reason');
            $member->rating = \request()->get('rating');
            $member->rating_year = \request()->get('rating_year');
            $member->year_of_maturity_ceremony = \request()->get('year_of_maturity_ceremony');
            $member->is_deleted = \request()->get('is_deleted');
            $member->reason_for_go_away = \request()->get('reason_for_go_away');
            $member->save();

            //Attachment
            if(request()->has('remove_attachment') ){
                $attachments = request()->get('remove_attachment') ;
                foreach ($attachments as $v) {
                    $attachment = Attachment::where('member_id', $member->id)->where('id', $v)->first();
                    Storage::delete($attachment->attachment_url);
                    $attachment->delete();
                }
            }
            if(request()->has('attachment') ){
                $attachments = request()->file('attachment') ;
                foreach ($attachments as $v) {
                    $extension = $v->extension();
                    $attachment = new Attachment();
                    $attachment->name = $v->getClientOriginalName();
                    $attachment->member_id = $member->id;
                    $attachment->attachment_url = 'xxx';
                    $attachment->save();
                    $path = $v->storeAs(
                        'public/attachment', $attachment->id.'.'.$extension
                    );
                    $attachment->attachment_url = $path;
                    $attachment->save();
                }
            }
            return \redirect()->route('member.edit', ['uuid' => $member->uuid])->withSuccess('Sửa thông tin thành công');
        } catch(Exception $e){
            return redirect()->back()->withErrors(['Có lỗi xẩy ra']);
        }



    }

    public function delete(){
        $member_ids = request()->get('member_ids');
        $avatars = Member::whereIn('uuid', $member_ids)->pluck('avatar');
        $ids = Member::whereIn('uuid', $member_ids)->pluck('id');
        $attachments = Attachment::whereIn('member_id', $ids)->pluck('attachment_url');
        foreach($avatars as $a){
            Storage::delete($a);
        }
        foreach($attachments as $a){
            Storage::delete($a);
        }
        Member::whereIn('uuid', $member_ids)->delete();
        Attachment::whereIn('member_id', $ids)->delete();

        return \redirect()->route('home')->withSuccess('Xoá thành công');
    }

    public function import(){
        return view('members.import');
    }

    public function uploads(){
        return view('members.uploads');
    }

    public function exportsample(){
        $view = View::make('export.sample');
        $contents = $view->render();
        $fileName = 'import_data_sample.xls';
        $path = public_path('export/excel/');
        $myfile = fopen($path.$fileName, "w");
        fwrite($myfile, $contents);
        $fileList[] = $fileName;
        return json_encode($fileList);
    }

    public function importData(Request $request){
        if ($request->hasFile('import_xls')) {
            $destinationPath = 'public/import';
            $extension = $request->file('import_xls')->getClientOriginalExtension();
            if($extension != 'xls' && $extension != 'xlsx'){
                return redirect('/member/import')->withErrors(['File sai định dạng. Vui lòng chọn file .xls hoặc .xlsx']);
            }
            $path = $request->file('import_xls')->store($destinationPath);
            $chk = false;
            $message = '';
            Excel::load('storage/app/'.$path, function ($reader) use ($chk, $message) {
                try{
                    $content = $reader->toArray();
                    $listToInsert =[];
                    $listToUpdate =[];
                    $positionList = Position::all();
                    $positionArr = [];
                    foreach ($positionList as $p){
                        $positionArr[$this->vn_to_str($p->name)] = $p->id;
                    }
                    $manageObjectArr = ['doan vien'=>1,'thanh nien' => 2, 'ca hai'=>0];
                    $nations = Nation::all();
                    $nationList = [];
                    foreach ($nations as $n){
                        $nationList[$this->vn_to_str($n->name)] = $n->id;
                    }
                    $religions = Religion::all();
                    $religionList = [];
                    foreach ($religions as $r){
                        $religionList[$this->vn_to_str($r->name)] = $r->id;
                    }
                    $yesNo = ['co'=>1,'khong'=>0,'roi'=>1,'chua'=>0];
                    $knowledges = Knowledge::all();
                    $knowledgeList = [];
                    foreach ($knowledges as $k){
                        $knowledgeList[$this->vn_to_str($k->name)] = $k->id;
                    }
                    //1 user is only manage 1 group, so group Id will be get from user
                    $user = Auth::user();
                    $groupId = $user->group->id;
                    foreach ($content[0] as $row) {
                        $fullname = $row['ho_va_ten'];
                        $code = $row['ma_doan_vien'];
                        if($code != ''){
                            $birthday = NULL;
                            if ($row['ngay_sinh']){
                                if(strpos($row['ngay_sinh'], '/') == false){
                                    $birthday = $row['ngay_sinh'];
                                } else{
                                    $birthday = Carbon::createFromFormat('d/m/Y',$row['ngay_sinh'])->toDateString();
                                }
                            }
                            $gender = (strtolower($row['gioi_tinh']) == 'nam')?1:0;
                            $chuc_vu = $this->vn_to_str($row['chuc_vu']);
                            $positionId = (array_key_exists($chuc_vu,$positionArr))?$positionArr[$chuc_vu]:1;
                            $manage_object = $this->vn_to_str($row['doi_tuong_quan_ly']);
                            $manageObjectId = (array_key_exists($manage_object,$manageObjectArr))?$manageObjectArr[$manage_object]:0;
                            $dantoc = $this->vn_to_str($row['dan_toc']);
                            $nationId = (array_key_exists($dantoc,$nationList))?$nationList[$dantoc]:1;
                            $tongiao = $this->vn_to_str($row['ton_giao']);
                            $religionId = (array_key_exists($tongiao,$religionList))?$religionList[$tongiao]:1;
                            $tinh_trang_hon_nhan = $this->vn_to_str($row['tinh_trang_hon_nhan']);
                            $relationCode = (array_key_exists($tinh_trang_hon_nhan,$yesNo))?$yesNo[$tinh_trang_hon_nhan]:0;
                            $join_date = NULL;
                            if($row['ngay_vao_doan']){
                                if(strpos($row['ngay_vao_doan'], '/') == false){
                                    $join_date = $row['ngay_vao_doan'];
                                } else{
                                    $join_date = Carbon::createFromFormat('d/m/Y',$row['ngay_vao_doan'])->toDateString();
                                }
                            }

                            $trinh_do = $this->vn_to_str($row['trinh_do']);
                            $knowledgeId = (array_key_exists($trinh_do,$knowledgeList))?$knowledgeList[$trinh_do]:1;
                            $educationLevel = $row['hoc_van'];
                            $dangvien = $this->vn_to_str($row['dang_vien']);
                            $isDangvien = (array_key_exists($dangvien,$yesNo))?$yesNo[$dangvien]:0;
                            $temp = [
                                'uuid'=>Str::uuid(),
                                'fullname'=>$fullname,
                                'code'=>$code,
                                'birthday'=>$birthday,
                                'gender'=>$gender,
                                'position'=>$positionId,
                                'group_id' => $groupId,
                                'religion'=>$religionId,
                                'nation'=>$nationId,
                                'relation'=>$relationCode,
                                'join_date'=>$join_date,
                                'knowledge'=>$knowledgeId,
                                'is_dangvien'=>$isDangvien,
                                'ascii_fullname' => $this->unicode_to_ascii($fullname),
                                'education_level'=>$educationLevel,
                                'position_text'=> $row['chuc_vu'],
                                'knowledge_text'=>$row['trinh_do'],
                                'nation_text'=>$row['dan_toc'],
                                'religion_text'=>$row['ton_giao'],
                                'manage_object'=>$manageObjectId,
                                'vilage'=>'',
                                'current_vilage'=>''
                            ];
                            $member = Member::where('code',$code)->first();
                            if(!$member){
                                $listToInsert[] = $temp;
                            } else{
                                $listToUpdate[] = $temp;
                            }
                        }
                    }
                    if(count($listToInsert)>0){
                        try{
                            DB::transaction(function () use ($listToInsert){
                                Member::insert($listToInsert);
                            });
                            session()->put('message_success','Thêm dữ liệu thành công.');
                        } catch (Exception $e){
                            session()->put('message_error','Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    } else {
                        session()->put('message_error','Những thành viên này đã tồn tại trong hệ thống.');
                    }
                } catch (Exception $e){
                    session()->put('message_error','Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
            Storage::delete($path);
            return redirect('member/import');
        } else{
            session()->put('message_error','Vui lòng chọn file dữ liệu.');
            return redirect('member/import');
        }
    }

    private function  vn_to_str ($str) {
        $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
            foreach($unicode as $nonUnicode=>$uni){

                $str = preg_replace("/($uni)/i", $nonUnicode, $str);

            }
            $str = str_replace(' ','_',$str);

            return strtolower($str);

    }
}

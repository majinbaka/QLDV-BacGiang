<?php

namespace App\Http\Controllers;

use App\BlockMember;
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
use Auth;
use Exception;
use Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function search(){
        $user = Auth::user();
        $code = request()->get('code');
        $fullname = request()->get('fullname');
        $uuid = request()->get('group');
        $page = \request()->get('page');
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
            }
            $memberc = $members->count();
            if($page){
                $members = $members->paginate(20)->setPageName($page);
                session()->put('current_page',$page);
            } else{
                $members = $members->paginate(20);
            }


            return view('home')
                ->with('code', $code)
                ->with('fullname', $fullname)
                ->with('group', $group)
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
            if($page){
                $members = $members->paginate(20)->setPageName($page);
                session()->put('current_page',$page);
            } else{
                $members = $members->paginate(20);
            }

            return view('home')
                ->with('code', $code)
                ->with('fullname', $fullname)
                ->with('group', $group)
                ->with('members', $members)
                ->with('groups', $groups)
                ->with('memberc', $memberc)
                ->with('page',$page)
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
            'education_level' => 'required'
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

            $avatar = null;
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
            $member->join_dang = Carbon::createFromFormat('d/m/Y', request()->get('join_dang'))->toDateString();
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
        } catch(Exception $e){

        }

        return \redirect()->route('member.edit', ['uuid' => $member->uuid])->withSuccess('Tạo thông tin thành công');
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
            'education_level' => 'required'
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
            $member->join_dang = Carbon::createFromFormat('d/m/Y', request()->get('join_dang'))->toDateString();
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
        } catch(Exception $e){

        }

        return \redirect()->route('member.edit', ['uuid' => $member->uuid])->withSuccess('Sửa thông tin thành công');

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
}

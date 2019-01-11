<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Member;
use App\Group;
use App\ItLevel;
use App\EnglishLevel;
use App\Knowledge;
use App\Political;
use App\Position;
use Auth;
use Exception;
use Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function search(){
        $groups = Group::where('level', 1)->get();

        $code = request()->get('code');
        $fullname = request()->get('fullname');
        $group = request()->get('group');
        $members = Member::select(['code', 'fullname', 'group_id', 'position']);

        if ($code !== null)
            $members = $members->where('code','like', '%'.$code.'%');
        if ($fullname !== null)
            $members = $members->where('fullname','like', '%'.$fullname.'%');
        if ($group !== null){
            $group = Group::where('uuid', $group)->first();
            $members = $members->where('group_id', $group->id);
        }
        $memberc = $members->count();
        $members = $members->paginate(20);

        return view('home')
            ->with('code', $code)
            ->with('fullname', $fullname)
            ->with('group', $group)
            ->with('members', $members)
            ->with('groups', $groups)
            ->with('memberc', $memberc)
            ->withSuccess(session()->get( 'success' ));
    }

    public function create(){
        $its = ItLevel::all();
        $englishs = EnglishLevel::all();
        $knowledges = Knowledge::all();
        $politicals = Political::all();
        $positions = Position::all();
        $groups = Group::all();
        return view('members.create', compact('its', 'englishs', 'knowledges', 'politicals', 'positions', 'groups'));
    }

    public function edit($uuid){
        $member = Member::where('uuid', $uuid)->first();
        $its = ItLevel::all();
        $englishs = EnglishLevel::all();
        $knowledges = Knowledge::all();
        $politicals = Political::all();
        $positions = Position::all();
        $groups = Group::all();

        return view('members.edit', compact('its', 'englishs', 'knowledges', 'politicals', 'positions', 'groups', 'member'))
        ->withSuccess(session()->get( 'success' ));
    }

    public function store(){
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }

        $validator = Validator::make(request()->all(), [
            'fullname' => 'required',
            'code' => 'required|unique:members,code',
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
            'join_dang' => 'required|date_format:d/m/Y',
            'avatar' => 'image',
        ],
        [
            'fullname.required' => 'Chưa nhập họ và tên đoàn viên',
            'code.required' => 'Chưa điền mã đoàn viên',
            'code.unique' => 'Mã đoàn viên đã tồn tại',
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
            'join_dang.required' => 'Chưa điền ngày vào đảng',
            'join_dang.date_format' => 'Ngày vào đảng chưa đúng định dạng',
            'avatar.image' => 'Ảnh đại diện chưa đúng định dạng'
        ]
        );

        if ($validator->fails()) {
            return redirect('member/create')
                ->withErrors($validator)
                ->withInput();
        }

        // try{
            $parent_group = Group::where('uuid', request()->get('group_id'))->first();
            if(!$parent_group){
                return redirect()->route('member.create')->withErrors(['Đơn vị không tồn tại']);
            }
            $group_id = $parent_group->id;

            $avatar = null;
            $member = new Member;
            $member->uuid = Str::uuid();
            $member->fullname = \request()->get('fullname');
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
        // } catch(Exception $e){

        // }

        return \redirect()->route('member.edit', ['uuid' => $member->uuid])->withSuccess('Tạo thông tin thành công');
    }
    public function update($uuid){
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }

        $member = Member::where('uuid', $uuid)->first();
        if(!$member)
            return redirect()->route('home')
                ->withErrors('Đoàn viên không tồn tại');
        $validator = Validator::make(request()->all(), [
            'fullname' => 'required',
            'code' => 'required|unique:members,code,'.$member->id,
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
            'join_dang' => 'required|date_format:d/m/Y',
            'avatar' => 'image',
        ],
        [
            'fullname.required' => 'Chưa nhập họ và tên đoàn viên',
            'code.required' => 'Chưa điền mã đoàn viên',
            'code.unique' => 'Mã đoàn viên đã tồn tại',
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
            'join_dang.required' => 'Chưa điền ngày vào đảng',
            'join_dang.date_format' => 'Ngày vào đảng chưa đúng định dạng',
            'avatar.image' => 'Ảnh đại diện chưa đúng định dạng'
        ]
        );

        if ($validator->fails()) {
            return redirect('member/'.$member->uuid.'/edit')
                ->withErrors($validator)
                ->withInput();
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
            $member->save();
        } catch(Exception $e){

        }

        return \redirect()->route('member.edit', ['uuid' => $member->uuid])->withSuccess('Sửa thông tin thành công');

    }
    public function delete(){
        $member_ids = request()->get('member_ids');
        $avatars = Member::whereIn('uuid', $member_ids)->pluck('avatar');
        foreach($avatars as $a){
            Storage::delete($a);
        }
        Member::whereIn('uuid', $member_ids)->delete();

        return \redirect()->back();
    }
}

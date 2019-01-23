<?php

namespace App\Http\Controllers;

use App\BlockMember;
use Exception;
use Validator;
use Auth;

class BlockMemberController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $list = BlockMember::all();

            return view('blockmembers.index', compact('list'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $item = BlockMember::find($id);

            return view('blockmembers.edit')->with('item', $item)->withSuccess(session()->get('success'));
        }

        return "Tính năng đang phát triển";
    }

    public function store(){
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ],
            [
                'name.required' => 'Chưa nhập tên khối đối tượng đoàn viên.',
            ]
        );

        if ($validator->fails()) {
            return redirect('blockmember')
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $item = new BlockMember();
            $item->name = \request()->get('name');
            $item->save();
        } catch(Exception $e){

        }

        return \redirect()->route('blockmember.index')->withSuccess('Thêm đối tượng đoàn viên thành công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $item = BlockMember::find($id);
            if (!$item){
                return redirect()->route('blockmember.index')
                    ->withErrors('Khối đối tượng đoàn viên này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
                [
                    'name.required' => 'Chưa nhập tên khối đối tượng đoàn viên',
                ]);

            if ($validator->fails()) {
                return redirect()->route('blockmember.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }

            try{
                $item->name = request()->get('name');
                $item->save();

                return redirect()->route('blockmember.edit', $item->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){

            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $list_ids = request()->get('block_member_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($list_ids))
        {
            BlockMember::whereIn('id', $list_ids)->delete();
            return redirect()->route('blockmember.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('blockmember.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('blockmember.index');
    }
}

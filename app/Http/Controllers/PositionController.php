<?php

namespace App\Http\Controllers;

use App\Position;
use Exception;
use Validator;
use Auth;

class PositionController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $positions = Position::all();

            return view('positions.index', compact('positions'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $position = Position::find($id);

            return view('positions.edit')->with('position', $position)->withSuccess(session()->get('success'));
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
            'name.required' => 'Chưa nhập chức vụ',
        ]
        );

        if ($validator->fails()) {
            return redirect('position')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $position = new Position;
            $position->name = \request()->get('name');
            $position->save();
        } catch(Exception $e){

        }

        return \redirect()->route('position.index')->withSuccess('Thêm chức vụ mới thành công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $position = Position::find($id);
            if (!$position){
                return redirect()->route('position.index')
                    ->withErrors('chức vụ này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập chức vụ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('position.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $position->name = request()->get('name');
                $position->save();

                return redirect()->route('position.edit', $position->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $position_ids = request()->get('position_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($position_ids))
        {
            Position::whereIn('id', $position_ids)->delete();
            return redirect()->route('position.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('position.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('position.index');
    }
}

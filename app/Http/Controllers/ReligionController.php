<?php

namespace App\Http\Controllers;

use App\Religion;
use Exception;
use Validator;
use Auth;

class ReligionController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $religions = Religion::all();

            return view('religions.index', compact('religions'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $religion = Religion::find($id);

            return view('religions.edit')->with('religion', $religion)->withSuccess(session()->get('success'));
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
            'name.required' => 'Chưa nhập cấp độ ngoại ngữ',
        ]
        );

        if ($validator->fails()) {
            return redirect('religion')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $religion = new Religion;
            $religion->name = \request()->get('name');
            $religion->save();
        } catch(Exception $e){

        }

        return \redirect()->route('religion.index')->withSuccess('Thêm trình độ tin học mới thánh công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $religion = Religion::find($id);
            if (!$religion){
                return redirect()->route('religion.index')
                    ->withErrors('trình độ tin học này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập cấp độ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('religion.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $religion->name = request()->get('name');
                $religion->save();

                return redirect()->route('religion.edit', $religion->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $religion_ids = request()->get('religion_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($religion_ids))
        {
            Religion::whereIn('id', $religion_ids)->delete();
            return redirect()->route('religion.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('religion.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('religion.index');
    }
}

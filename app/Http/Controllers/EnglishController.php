<?php

namespace App\Http\Controllers;

use App\EnglishLevel;
use Exception;
use Validator;
use Auth;

class EnglishController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $englishs = EnglishLevel::all();

            return view('englishs.index', compact('englishs'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $english = EnglishLevel::find($id);

            return view('englishs.edit')->with('english', $english)->withSuccess(session()->get('success'));
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
            return redirect('english')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $english = new EnglishLevel;
            $english->name = \request()->get('name');
            $english->save();
        } catch(Exception $e){

        }

        return \redirect()->route('english.index')->withSuccess('Thêm trình độ ngoại ngữ mới thành công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $english = EnglishLevel::find($id);
            if (!$english){
                return redirect()->route('english.index')
                    ->withErrors('trình độ ngoại ngữ này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập cấp độ ngoại ngữ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('english.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $english->name = request()->get('name');
                $english->save();

                return redirect()->route('english.edit', $english->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $english_ids = request()->get('english_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($english_ids))
        {
            EnglishLevel::whereIn('id', $english_ids)->delete();
            return redirect()->route('english.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('english.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('english.index');
    }
}

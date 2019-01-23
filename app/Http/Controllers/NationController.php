<?php

namespace App\Http\Controllers;

use App\Nation;
use Exception;
use Validator;
use Auth;

class NationController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $nations = Nation::all();

            return view('nations.index', compact('nations'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $nation = Nation::find($id);

            return view('nations.edit')->with('nation', $nation)->withSuccess(session()->get('success'));
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
            return redirect('nation')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $nation = new Nation;
            $nation->name = \request()->get('name');
            $nation->save();
        } catch(Exception $e){

        }

        return \redirect()->route('nation.index')->withSuccess('Thêm trình độ tin học mới thành công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $nation = Nation::find($id);
            if (!$nation){
                return redirect()->route('nation.index')
                    ->withErrors('trình độ tin học này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập cấp độ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('nation.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $nation->name = request()->get('name');
                $nation->save();

                return redirect()->route('nation.edit', $nation->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $nation_ids = request()->get('nation_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($nation_ids))
        {
            Nation::whereIn('id', $nation_ids)->delete();
            return redirect()->route('nation.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('nation.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('nation.index');
    }
}

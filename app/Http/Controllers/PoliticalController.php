<?php

namespace App\Http\Controllers;

use App\Political;
use Exception;
use Validator;
use Auth;

class PoliticalController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $politicals = Political::all();

            return view('politicals.index', compact('politicals'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $political = Political::find($id);

            return view('politicals.edit')->with('political', $political)->withSuccess(session()->get('success'));
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
            'name.required' => 'Chưa nhập chính trị',
        ]
        );

        if ($validator->fails()) {
            return redirect('political')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $political = new Political;
            $political->name = \request()->get('name');
            $political->save();
        } catch(Exception $e){

        }

        return \redirect()->route('political.index')->withSuccess('Thêm trình độ chính trị mới thành công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $political = Political::find($id);
            if (!$political){
                return redirect()->route('political.index')
                    ->withErrors('trình độ chính trị này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập chính trị',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('political.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $political->name = request()->get('name');
                $political->save();

                return redirect()->route('political.edit', $political->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $political_ids = request()->get('political_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($political_ids))
        {
            Political::whereIn('id', $political_ids)->delete();
            return redirect()->route('political.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('political.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('political.index');
    }
}

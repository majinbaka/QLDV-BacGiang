<?php

namespace App\Http\Controllers;

use App\ItLevel;
use Exception;
use Validator;
use Auth;

class ItController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $its = ItLevel::all();

            return view('its.index', compact('its'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $it = ItLevel::find($id);

            return view('its.edit')->with('it', $it)->withSuccess(session()->get('success'));
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
            return redirect('it')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $it = new ItLevel;
            $it->name = \request()->get('name');
            $it->save();
        } catch(Exception $e){

        }

        return \redirect()->route('it.index')->withSuccess('Thêm trình độ tin học mới thánh công');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $it = ItLevel::find($id);
            if (!$it){
                return redirect()->route('it.index')
                    ->withErrors('trình độ tin học này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập cấp độ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('it.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $it->name = request()->get('name');
                $it->save();

                return redirect()->route('it.edit', $it->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $it_ids = request()->get('it_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($it_ids))
        {
            ItLevel::whereIn('id', $it_ids)->delete();
            return redirect()->route('it.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('it.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('it.index');
    }
}

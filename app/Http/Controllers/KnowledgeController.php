<?php

namespace App\Http\Controllers;

use App\Knowledge;
use Exception;
use Validator;
use Auth;

class KnowledgeController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $knowledges = Knowledge::all();

            return view('knowledges.index', compact('knowledges'))->withSuccess(session()->get( 'success' ));;
        }

        return "Tính năng đang phát triển";
    }

    public function edit($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $knowledge = Knowledge::find($id);

            return view('knowledges.edit')->with('knowledge', $knowledge)->withSuccess(session()->get('success'));
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
            return redirect('knowledge')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $knowledge = new Knowledge;
            $knowledge->name = \request()->get('name');
            $knowledge->save();
        } catch(Exception $e){

        }

        return \redirect()->route('knowledge.index');
    }

    public function update($id){
        $user = Auth::user();
        if ($user->isAn('admin')){
            $knowledge = Knowledge::find($id);
            if (!$knowledge){
                return redirect()->route('knowledge.index')
                    ->withErrors('trình độ ngoại ngữ này không tồn tại');
            }

            $validator = Validator::make(request()->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập cấp độ ngoại ngữ',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('knowledge.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            try{
                $knowledge->name = request()->get('name');
                $knowledge->save();

                return redirect()->route('knowledge.edit', $knowledge->id)->withSuccess('Sửa thông tin thành công');
            } catch(Exception $e){
    
            }
        }

        return "Tính năng đang phát triển";
    }

    public function delete(){
        $knowledge_ids = request()->get('knowledge_ids');
        $user = Auth::user();
        if (!$user->isAn('admin')){
            return "Tính năng đang phát triển";
        }
        if (is_array($knowledge_ids))
        {
            Knowledge::whereIn('id', $knowledge_ids)->delete();
            return redirect()->route('knowledge.index')->withSuccess('Xoá thành công');
        }
        else{
            return redirect()->route('knowledge.index')->withSuccess('Xoá thành công');
        }

        return redirect()->route('knowledge.index');
    }
}

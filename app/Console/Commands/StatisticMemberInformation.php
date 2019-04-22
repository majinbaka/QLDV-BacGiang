<?php

namespace App\Console\Commands;

use App\Group;
use App\Member;
use App\Statistical;
use Illuminate\Console\Command;
use App\User;
use Bouncer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StatisticMemberInformation extends Command
{
    protected $signature = 'member:statistic';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Statistical::truncate();
        $userList = User::all();
        $totalMemberByGroupId = Member::select(DB::raw('count(*) as total'),'group_id','manage_object')->where('is_join_maturity_ceremony',0)->groupBy('group_id','manage_object')->get();
        $list = [];
        foreach ($userList as $user){
            $group= $user->group;
            if($group){
                $ids = $group->getIdsG();
            } else{
                $ids = Group::all()->pluck('id')->toArray();
            }
            // tinh so huyen, thanh doan va doan truc thuoc
            $totalChild = Group::select(DB::raw('count(*) as total'),'level')->whereIn('id',$ids)->groupBy('level')->get();
            foreach ($totalChild as $item){
                $list[] = [
                    'user_id'=>$user->id,
                    'key'=>'tong_donvi_cap_'.$item->level,
                    'value'=>$item->total
                ];
            }
            // tinh toan tong so doan vien va thanh nien do don vi cua use nay quan ly
            $total_doanvien = 0;
            $total_thanhnien = 0;
            foreach ($totalMemberByGroupId as $item){
                if(in_array($item->group_id,$ids)){
                    if($item->manage_object == 1 || $item->manager_object == 0){
                        $total_doanvien += $item->total;
                    }
                    if($item->manage_object == 2 || $item->manager_object == 0){
                        $total_thanhnien += $item->total;
                    }
                }
            }
            $list[] = [
                'user_id'=>$user->id,
                'key'=>'total_doanvien',
                'value'=>$total_doanvien
            ];
            $list[] = [
                'user_id'=>$user->id,
                'key'=>'total_thanhnien',
                'value'=>$total_thanhnien
            ];



        }
        Statistical::insert($list);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class member extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i =0; $i < 80000; $i++)
        DB::table('members')->insert([
            'uuid' => str_random(10).$i,
            'avatar' => str_random(10).$i,
            'fullname' => str_random(10).$i,
            'code' => str_random(10).$i,
            'birthday' => '2012-11-11',
            'gender' => 1,
            'position' => 1,
            'term' => 1,
            'religion' => 1,
            'group_id' => 1,
            'nation' => 1,
            'relation' => 1,
            'relation' => 1,
            'relation' => 1,
            'join_date' => '2012-11-11',
            'city' => 1,
            'district' => 1,
            'commune' => 1,
            'vilage' => 1,
            'is_dangvien' => 1,
            'current_city' => 1,
            'current_district' => 1,
            'current_commune' => 1,
            'current_vilage' => 1,
            'knowledge' => 1,
            'political' => 1,
            'it_level' => 1,
            'english_level' => 1,
            'join_dang' => '2012-11-11',
        ]);
    }
}

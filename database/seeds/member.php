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
        $first = ['Nguyễn', 'Vũ', 'Đinh', 'Doãn'];
        $last = ['Anh', 'Long', 'Linh', 'Dung'];
        $middle = ['Việt', 'Minh', 'Hoàng', 'Thị', 'Văn'];
        for ($i =0; $i < 100; $i++) {
            DB::table('members')->insert([
            'uuid' => str_random(10).$i,
            'avatar' => str_random(10).$i,
            'fullname' => $first[rand(0,3)].' '.$middle[rand(0,3)].' '.$last[rand(0,3)],
            'code' => str_random(6).$i,
            'birthday' => '2012-11-11',
            'gender' => rand(0,1),
            'position' => rand(1,2),
            'term' => '2000-2010',
            'religion' => rand(1,2),
            'group_id' => rand(1,24),
            'nation' => 'kinh',
            'relation' => 'Độc thân',
            'join_date' => '2012-11-11',
            'city' => 'Bắc Giang',
            'district' => '',
            'commune' => '',
            'vilage' => 'Bắc Giang',
            'is_dangvien' => rand(0,1),
            'current_city' => 'Bắc Giang',
            'current_district' => '',
            'current_commune' => '',
            'current_vilage' => 'Bắc Giang',
            'knowledge' => rand(1,3),
            'political' => rand(1,4),
            'it_level' => rand(1,3),
            'english_level' => rand(1,5),
            'join_dang' => '2012-11-11',
        ]);
        }

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Huyện đoàn Yên Dũng",
            'parent_id' => 0,
            'level' => 1,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Huyện đoàn Hiệp Hoà",
            'parent_id' => 0,
            'level' => 1,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Huyện đoàn Việt Yên",
            'parent_id' => 0,
            'level' => 1,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Huyện đoàn Yên Thế",
            'parent_id' => 0,
            'level' => 1,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Huyện đoàn Tân Yên",
            'parent_id' => 0,
            'level' => 1,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Thành Đoàn Bắc Giang",
            'parent_id' => 0,
            'level' => 1,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Đoàn công ty đạm Hà Bắc",
            'parent_id' => 0,
            'level' => 1,
        ]);
//
        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Đoàn xã Cảnh Thuỵ",
            'parent_id' => 1,
            'level' => 2,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Đoàn Xã Thắng Cương",
            'parent_id' => 1,
            'level' => 2,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Đoàn xã Đức Giang",
            'parent_id' => 1,
            'level' => 2,
        ]);

        DB::table('groups')->insert([
            'uuid' => str_random(10).$i,
            'name' => "Đoàn trường THPT Yên Dũng Số 1",
            'parent_id' => 1,
            'level' => 2,
        ]);
// 2
DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn xã Cảnh Thuỵ",
    'parent_id' => 2,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn Xã Thắng Cương",
    'parent_id' => 2,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn xã Đức Giang",
    'parent_id' => 2,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn trường THPT Yên Dũng Số 1",
    'parent_id' => 2,
    'level' => 2,
]);
// 3
DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn xã Cảnh Thuỵ",
    'parent_id' => 3,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn Xã Thắng Cương",
    'parent_id' => 3,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn xã Đức Giang",
    'parent_id' => 3,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn trường THPT Yên Dũng Số 1",
    'parent_id' => 3,
    'level' => 2,
]);
// 4
DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn xã Cảnh Thuỵ",
    'parent_id' => 4,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn Xã Thắng Cương",
    'parent_id' => 4,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn xã Đức Giang",
    'parent_id' => 4,
    'level' => 2,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Đoàn trường THPT Yên Dũng Số 1",
    'parent_id' => 4,
    'level' => 2,
]);
// 5


DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Chi Đoàn thôn Nhất",
    'parent_id' => 8,
    'level' => 3,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Chi đoàn thôn bảy",
    'parent_id' =>8,
    'level' => 3,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Chi đoàn thôn Đông",
    'parent_id' => 8,
    'level' => 3,
]);

DB::table('groups')->insert([
    'uuid' => str_random(10).$i,
    'name' => "Chi Đoàn thôn Tây",
    'parent_id' => 8,
    'level' => 3,
]);

DB::table('english_levels')->insert([
    'name' => "A1",
]);
DB::table('english_levels')->insert([
    'name' => "A2",
]);
DB::table('english_levels')->insert([
    'name' => "B1",
]);
DB::table('english_levels')->insert([
    'name' => "B2",
]);
DB::table('english_levels')->insert([
    'name' => "C1",
]);
DB::table('english_levels')->insert([
    'name' => "C2",
]);

DB::table('it_levels')->insert([
    'name' => "A",
]);
DB::table('it_levels')->insert([
    'name' => "B",
]);
DB::table('it_levels')->insert([
    'name' => "C",
]);
DB::table('knowledges')->insert([
    'name' => "Trung Cấp",
]);
DB::table('knowledges')->insert([
    'name' => "Cao Đẳng",
]);
DB::table('knowledges')->insert([
    'name' => "Đại học",
]);
DB::table('knowledges')->insert([
    'name' => "Cao học",
]);

DB::table('politicals')->insert([
    'name' => "Sơ cấp",
]);
DB::table('politicals')->insert([
    'name' => "Trung cấp",
]);
DB::table('politicals')->insert([
    'name' => "Cao cấp",
]);

DB::table('positions')->insert([
    'name' => "Đoàn viên",
]);
DB::table('positions')->insert([
    'name' => "Đảng viên",
]);
    }
}

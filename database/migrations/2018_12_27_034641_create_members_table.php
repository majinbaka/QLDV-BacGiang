<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique()->index();// uid
            $table->string('avatar');// anh dai dien
            $table->string('fullname');// ten
            $table->string('code')->unique()->index();// ma doan vien
            $table->date('birthday');// sinh nhat
            $table->tinyInteger('gender');//gioi tinh
            $table->integer('position');// chuc vu
            $table->string('term');// nhiem ky
            $table->integer('group_id');// don vi
            $table->string('religion');// ton giao
            $table->string('nation');// dan toc
            $table->string('relation');// tinh trang hon nhan
            $table->date('join_date');// ngay vao doan
            $table->string('city');// Tinh/ TP
            $table->string('district');// Quan huyen
            $table->string('commune');// xa
            $table->string('vilage');// que quan
            $table->string('current_city');// Tinh/ TP hien tai
            $table->string('current_district');// Quan huyen hien tai
            $table->string('current_commune');// xa hien tai
            $table->string('current_vilage');// que quan hien tai
            $table->string('knowledge');// trinh do
            $table->string('political');// chinh tri
            $table->string('it_level');// tin hoc
            $table->string('english_level');// ngoai ngu
            $table->tinyInteger('is_dangvien');// dang vien
            $table->date('join_dang');// ngay vao dang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

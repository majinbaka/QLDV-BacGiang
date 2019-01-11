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
            $table->string('uuid')->unique();// uid
            $table->string('avatar')->nullable();// anh dai dien
            $table->string('fullname');// ten
            $table->string('code')->unique()->index();// ma doan vien
            $table->date('birthday')->nullable();// sinh nhat
            $table->tinyInteger('gender');//gioi tinh
            $table->integer('position');// chuc vu
            $table->string('term')->nullable();// nhiem ky
            $table->integer('group_id');// don vi
            $table->string('religion');// ton giao
            $table->string('nation');// dan toc
            $table->string('relation');// tinh trang hon nhan
            $table->date('join_date');// ngay vao doan
            $table->string('city')->nullable();// Tinh/ TP
            $table->string('district')->nullable();// Quan huyen
            $table->string('commune')->nullable();// xa
            $table->string('vilage');// que quan
            $table->string('current_city')->nullable();// Tinh/ TP hien tai
            $table->string('current_district')->nullable();// Quan huyen hien tai
            $table->string('current_commune')->nullable();// xa hien tai
            $table->string('current_vilage');// que quan hien tai
            $table->integer('knowledge')->nullable();// trinh do
            $table->integer('political')->nullable();// chinh tri
            $table->integer('it_level')->nullable();// tin hoc
            $table->integer('english_level')->nullable();// ngoai ngu
            $table->tinyInteger('is_dangvien');// dang vien
            $table->date('join_dang')->nullable();// ngay vao dang
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

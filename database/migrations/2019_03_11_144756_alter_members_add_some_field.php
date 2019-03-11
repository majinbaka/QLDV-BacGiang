<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMembersAddSomeField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->integer('is_join_maturity_ceremony')->default(0)->nullable();
            $table->string('from_place')->nullable();
            $table->string('from_reason')->nullable();
            $table->date('from_date')->nullable();
            $table->string('to_place')->nullable();
            $table->string('to_reason')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('is_go_far_away')->default(0)->nullable();
            $table->string('delete_reason')->nullable();
            $table->string('rating')->nullable();
            $table->string('rating_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['is_join_maturity_ceremony','from_place','from_reason','from_date','to_place','to_reason','to_date','is_go_far_away','delete_reason','rating','rating_year']);
        });
    }
}

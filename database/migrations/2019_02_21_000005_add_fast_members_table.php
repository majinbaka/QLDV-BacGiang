<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFastMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('position_text')->nullable();
            $table->string('knowledge_text')->nullable();
            $table->string('political_text')->nullable();
            $table->string('it_text')->nullable();
            $table->string('english_text')->nullable();
            $table->string('nation_text')->nullable();
            $table->string('religion_text')->nullable();
            $table->string('blockmember_text')->nullable();
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
            $table->dropColumn('position_text');
            $table->dropColumn('knowledge_text');
            $table->dropColumn('political_text');
            $table->dropColumn('it_text');
            $table->dropColumn('english_text');
            $table->dropColumn('nation_text');
            $table->dropColumn('religion_text');
            $table->dropColumn('blockmember_text');
        });
    }
}

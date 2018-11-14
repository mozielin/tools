<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique();
            $table->string('realname')->nullable();
            $table->string('company')->nullable();
            $table->string('note')->nullable();
            $table->integer('c_id')->nullable();
            $table->integer('p_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('realname');
            $table->dropColumn('company');
            $table->dropColumn('note');
            $table->dropColumn('c_id');
            $table->dropColumn('p_id');
        });
    }
}

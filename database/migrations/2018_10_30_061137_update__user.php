<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('users', function (Blueprint $table) {
            $table->string('fb_id')->nullable()->unique();
            $table->string('g+_id')->nullable()->unique();
            $table->string('fb_avatar')->nullable();
            $table->string('g+_avatar')->nullable();
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
            $table->dropColumn('fb_id');
            $table->dropColumn('g+_id');
            $table->dropColumn('fb_avatar');
            $table->dropColumn('g+_avatar');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRewardPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_points', function (Blueprint $table) {
            \DB::select("ALTER TABLE `reward_points` CHANGE `description` `description` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

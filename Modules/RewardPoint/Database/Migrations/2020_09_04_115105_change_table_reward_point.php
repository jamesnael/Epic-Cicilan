<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableRewardPoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_points', function (Blueprint $table) {
            \DB::select("ALTER TABLE `reward_points` CHANGE `redeem_point` `redeem_point` INT(11) NULL;");
            \DB::select("ALTER TABLE `reward_points` CHANGE `kuota` `kuota` INT(11) NULL;");
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

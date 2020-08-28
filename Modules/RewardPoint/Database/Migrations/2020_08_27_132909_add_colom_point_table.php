<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_points', function (Blueprint $table) {
            $table->integer('redeem_point_main_coordinator')->nullable()->after('reward_name');
            $table->integer('redeem_point_regional_coordinator')->nullable()->after('redeem_point_main_coordinator');
            $table->integer('redeem_point_agency')->nullable()->after('redeem_point_regional_coordinator');
            $table->integer('redeem_point_sales')->nullable()->after('redeem_point_agency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_points', function (Blueprint $table) {
            // 
        });
    }
}

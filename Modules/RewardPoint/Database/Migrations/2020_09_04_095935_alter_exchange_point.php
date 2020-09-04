<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExchangePoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exchange_point_sales', function (Blueprint $table) {
            \DB::select("ALTER TABLE `exchange_point_sales` CHANGE `sales_point_id` `sales_id` INT(11) NOT NULL;");
        });

        Schema::table('exchange_point_sub_agents', function (Blueprint $table) {
            \DB::select("ALTER TABLE `exchange_point_sub_agents` CHANGE `sub_agent_point_id` `agency_id` INT(11) NOT NULL;");
        });

        Schema::table('exchange_point_koor_umums', function (Blueprint $table) {
            \DB::select("ALTER TABLE `exchange_point_koor_umums` CHANGE `koordinator_umum_point_id` `main_coordinator_id` INT(11) NOT NULL;");
        });

        Schema::table('exchange_point_koor_wilayahs', function (Blueprint $table) {
            \DB::select("ALTER TABLE `exchange_point_koor_wilayahs` CHANGE `koordinator_wilayah_point_id` `regional_coordinator_id` INT(11) NOT NULL;");
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

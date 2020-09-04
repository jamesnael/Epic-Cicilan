<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPpnNullableBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            \DB::select("ALTER TABLE `bookings` 
                CHANGE COLUMN `ppn` `ppn` DOUBLE NULL DEFAULT NULL ,
                CHANGE COLUMN `dp_amount` `dp_amount` DOUBLE NOT NULL DEFAULT 0.00 ,
                CHANGE COLUMN `amount` `amount` DOUBLE NULL ,
                CHANGE COLUMN `credits` `credits` DOUBLE NOT NULL DEFAULT 0.00 ;
            ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
}

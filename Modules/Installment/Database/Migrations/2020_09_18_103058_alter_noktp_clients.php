<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNoktpClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            \DB::select("ALTER TABLE `clients` 
                CHANGE COLUMN `no_ktp` `no_ktp` VARCHAR(191) NULL DEFAULT NULL ,
                CHANGE COLUMN `npwp` `npwp` VARCHAR(191) NULL DEFAULT NULL ;
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
        Schema::table('clients', function (Blueprint $table) {

        });
    }
}

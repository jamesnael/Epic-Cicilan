<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoHpKorutKorwilSubAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->string('no_hp_principal')->nullable();
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->string('no_hp_principal')->nullable();
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->string('no_hp_principal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['no_hp_principal']);
        });
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->dropColumn(['no_hp_principal']);
        });
        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->dropColumn(['no_hp_principal']);
        });
    }
}

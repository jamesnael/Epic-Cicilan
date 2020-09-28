<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnHandover extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('handovers', function (Blueprint $table) {
            $table->string('no_bast')->nullable()->after('handover_sign_date');
            $table->string('nama_petugas')->nullable()->after('no_bast');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('handovers', function (Blueprint $table) {

        });
    }
}

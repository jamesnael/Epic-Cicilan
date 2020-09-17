<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProgramIdBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id')->nullable();
            $table->string('nama_program');
            $table->longText('harga_termasuk')->nullable();
            $table->longText('harga_tidak_termasuk')->nullable();
            $table->string('gimmick')->nullable();
            $table->text('keterangan_program')->nullable();
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
            $table->dropColumn(['program_id', 'nama_program', 'harga_termasuk', 'harga_tidak_termasuk', 'gimmick', 'keterangan_program']);
        });
    }
}

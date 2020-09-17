<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipeProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_programs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('slug')->nullable();
            $table->string('nama_program');
            $table->longText('harga_termasuk')->nullable();
            $table->longText('harga_tidak_termasuk')->nullable();
            $table->string('gimmick')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipe_programs');
    }
}

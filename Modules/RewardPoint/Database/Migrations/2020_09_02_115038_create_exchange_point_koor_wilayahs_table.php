<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDelets;

class CreateExchangePointKoorWilayahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_point_koor_wilayahs', function (Blueprint $table) {
            $table->id();
            $table->integer('reward_point_id');
            $table->integer('koordinator_wilayah_point_id');
            $table->integer('exchange_point');
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
        Schema::dropIfExists('exchange_point_koor_wilayahs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('unit_name')->nullable();
            $table->string('unit_type');
            $table->string('unit_number')->nullable();
            $table->string('unit_block')->nullable();
            $table->string('surface_area')->nullable();
            $table->string('building_area')->nullable();
            $table->string('floor_name')->nullable();
            $table->string('floorplan_image')->nullable();
            $table->string('points')->nullable();
            $table->string('electrical_power')->nullable();
            $table->double('utj')->nullable();
            $table->double('closing_fee')->nullable();
            $table->integer('available')->nullable();

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
        Schema::dropIfExists('units');
    }
}

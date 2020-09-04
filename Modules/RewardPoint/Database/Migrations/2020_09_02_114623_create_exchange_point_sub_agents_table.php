<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangePointSubAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_point_sub_agents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sub_agent_point_id');
            $table->integer('reward_point_id');
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
        Schema::dropIfExists('exchange_point_sub_agents');
    }
}

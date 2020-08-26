<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddColomAgencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sales_commission')->nullable();
            $table->unsignedBigInteger('id_agency_commision')->nullable();
            $table->unsignedBigInteger('id_regional_coordinator_commission')->nullable();
            $table->unsignedBigInteger('id_main_coordinator_commission')->nullable();
            $table->double('sales_commission')->nullable();
            $table->double('agency_commission')->nullable();
            $table->double('regional_coordinator_commission')->nullable();
            $table->double('main_coordinator_commission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_colom_agency');
    }
}

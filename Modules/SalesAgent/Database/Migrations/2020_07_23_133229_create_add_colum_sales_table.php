<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddColumSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {

            $table->unsignedBigInteger('main_coordinator_id')->index()->after('agency_id');
            $table->unsignedBigInteger('regional_coordinator_id')->index()->nullable()->after('main_coordinator_id');

            $table->double('sales_commission')->nullable()->after('file_npwp');
            $table->double('agency_commission')->nullable()->after('sales_commission');
            $table->double('regional_coordinator_commission')->nullable()->after('agency_commission');
            $table->double('main_coordinator_commission')->nullable()->after('regional_coordinator_commission');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_colum_sales');
    }
}

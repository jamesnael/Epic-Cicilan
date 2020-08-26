<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomPphFinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->double('pph_final', 20, 2)->default(0)->after('address');
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->double('pph_final', 20, 2)->default(0)->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regional_coordinators');
        Schema::dropIfExists('regional_coordinators');
    }
}

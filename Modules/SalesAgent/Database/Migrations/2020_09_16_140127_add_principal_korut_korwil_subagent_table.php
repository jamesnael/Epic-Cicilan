<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrincipalKorutKorwilSubagentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->string('principal')->nullable()->after('address');
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->string('principal')->nullable()->after('address');
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->string('principal')->nullable()->after('account_name');
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
            $table->dropColumn(['principal']);
        });
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->dropColumn(['principal']);
        });
        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->dropColumn(['principal']);
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('city');
            $table->string('rek_number')->nullable()->after('bank_name');
            $table->string('account_name')->nullable()->after('rek_number');
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('pph_final');
            $table->string('rek_number')->nullable()->after('bank_name');
            $table->string('account_name')->nullable()->after('rek_number');
        });

        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('pph_final');
            $table->string('rek_number')->nullable()->after('bank_name');
            $table->string('account_name')->nullable()->after('rek_number');
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
            // 
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            // 
        });

        Schema::table('regional_coordinators', function (Blueprint $table) {
            // 
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoktpNpwpAlamatktp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {

            $table->string('alamat_ktp')->nullable()->after('client_address');
            $table->integer('no_ktp',25)->nullable()->after('alamat_ktp');
            $table->integer('npwp',25)->nullable()->after('no_ktp');
            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}

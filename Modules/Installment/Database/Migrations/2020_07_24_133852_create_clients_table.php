<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('slug')->nullable();
            $table->string('client_number');
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone_number')->nullable();
            $table->string('client_mobile_number')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_file_ktp');
            $table->string('client_file_npwp');

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
        Schema::dropIfExists('clients');
    }
}

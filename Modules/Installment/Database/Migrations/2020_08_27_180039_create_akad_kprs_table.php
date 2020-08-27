<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkadKprsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akad_kprs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_id')->nullable();
            $table->date('akad_date');
            $table->time('akad_time')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->string('akad_doc_file_name')->nullable();
            $table->string('approval_client_status')->nullable();
            $table->string('approval_developer_status')->nullable();
            $table->string('approval_notaris_status')->nullable();    
            $table->date('akad_sign_date')->nullable();
            $table->string('akad_doc_sign_file_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akad_kprs');
    }
}

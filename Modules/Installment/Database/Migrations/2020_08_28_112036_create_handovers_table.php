<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDelets;

class CreateHandoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handovers', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->date('handover_date');
            $table->time('time')->nullable();
            $table->string('location');
            $table->text('address');
            $table->string('handover_doc_file_name');
            $table->string('approval_client_status')->nullable();
            $table->string('approval_developer_status')->nullable();
            $table->string('approval_notaris_status')->nullable();
            $table->string('handover_doc_sign_name')->nullable();
            $table->dateTime('handover_sign_date')->nullable();
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
        Schema::dropIfExists('handovers');
    }
}

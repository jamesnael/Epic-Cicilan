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
            $table->time('handover_time');
            $table->string('location');
            $table->text('address');
            $table->string('handover_doc_file_name');
            $table->string('approval_client_status');
            $table->string('approval_developer_status');
            $table->string('approval_notaris_status');
            $table->string('handover_doc_sign_name');
            $table->dateTime('handover_sign_date');
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

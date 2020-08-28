<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDelets;

class CreateSprsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprs', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->date('print_date');
            $table->date('sent_date')->nullable();
            $table->date('received_date')->nullable();
            $table->string('approval_status')->default('Pending');
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
        Schema::dropIfExists('sprs');
    }
}

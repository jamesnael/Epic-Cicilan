<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->integer('unit_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('ppn')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->double('dp_amount')->nullable();
            $table->double('first_payment')->nullable();
            $table->double('principal')->nullable();
            $table->double('installment')->nullable();
            $table->integer('installment_time')->nullable();
            $table->integer('due_date')->nullable();
            $table->double('amount')->nullable();
            $table->double('credits')->nullable();
            $table->string('payment_method_utj')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('card_number')->nullable();
            $table->integer('point')->nullable();

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
        Schema::dropIfExists('bookings');
    }
}

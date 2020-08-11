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
            $table->double('total_amount');
            $table->double('ppn');
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->double('dp_amount');
            $table->double('first_payment');
            $table->double('principal');
            $table->double('installment');
            $table->integer('installment_time');
            $table->integer('due_date');
            $table->double('amount');
            $table->double('credits');
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

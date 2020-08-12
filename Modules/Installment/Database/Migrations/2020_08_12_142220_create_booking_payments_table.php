<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('booking_id');
            $table->string('payment')->nullable();
            $table->date('due_date')->nullable();
            $table->double('installment')->nullable();
            $table->double('credit')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('va_number')->nullable();
            $table->double('total_paid')->nullable();
            $table->integer('number_of_delays')->nullable();
            $table->double('fine')->nullable();
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
        Schema::dropIfExists('booking_payments');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPgNumberBookingPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->string('pg_number')->nullable();
            $table->boolean('paid_mail')->default(false);
            $table->boolean('pending_mail')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->dropColumn(['pg_number', 'paid_mail', 'pending_mail']);
        });
    }
}

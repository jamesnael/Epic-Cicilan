<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomBookingPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->date('sp1_date')->nullable()->after('due_date');
            $table->date('sp2_date')->nullable()->after('sp1_date');
            $table->date('sp3_date')->nullable()->after('sp2_date');
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

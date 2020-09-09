<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusEmailBookingPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->boolean('notification_mail_7')->default(false);
            $table->boolean('notification_mail_1')->default(false);
            $table->boolean('notification_mail_sp1')->default(false);
            $table->boolean('notification_mail_sp2')->default(false);
            $table->boolean('notification_mail_sp3')->default(false);
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
            $table->dropColumn([
                'notification_mail_7',
                'notification_mail_1',
                'notification_mail_sp1',
                'notification_mail_sp2',
                'notification_mail_sp3',
            ]);
        });
    }
}

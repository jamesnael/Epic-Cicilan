<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomBookingAjbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->longtext('deal_closer')->nullable()->after('point');
        });

        Schema::table('akte_jual_belis', function (Blueprint $table) {
            $table->string('ajb_number')->nullable()->after('ajb_doc_sign_file_name');
            $table->date('upload_date')->nullable()->after('ajb_number');
            $table->string('notaris_name')->nullable()->after('upload_date');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->date('email_verified_at')->nullable()->after('client_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'deal_closer',
            ]);
        });

        Schema::table('akte_jual_belis', function (Blueprint $table) {
            $table->dropColumn([
                'ajb_number','upload_date','notaris_name'
            ]);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'email_verified_at',
            ]);
        });
    }
}

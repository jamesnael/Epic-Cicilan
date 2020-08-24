<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_clients', function (Blueprint $table) {
            $table->integer('booking_id')->nullable()->after('id');
            $table->string('file_keterangan_kerja')->nullable()->after('file_spt');
            $table->string('file_tabungan_3_bulan_terakhir')->nullable()->after('file_keterangan_kerja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_clients', function (Blueprint $table) {
            $table->dropColumn(['client_id','unit_id']);
        });
    }
}

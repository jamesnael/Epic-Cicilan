<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileOtherDocumentClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_clients', function (Blueprint $table) {
            $table->string('file_npwp_perusahaan')->nullable();
            $table->string('file_buku_perusahaan')->nullable();
            $table->string('file_other')->nullable();
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
            $table->dropColumn(['file_npwp_perusahaan','file_buku_perusahaan','file_other']);
        });
    }
}

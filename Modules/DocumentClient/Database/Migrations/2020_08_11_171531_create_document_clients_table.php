<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->integer('client_id')->nullable();
            $table->date('submission_date')->nullable();
            $table->string('client_profesion')->nullable();
            $table->string('file_ktp_pemohon')->nullable();
            $table->string('file_ktp_suami_istri')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_surat_nikah')->nullable();
            $table->string('file_akta_lahir_ijazah')->nullable();
            $table->string('file_npwp')->nullable();
            $table->string('file_siup')->nullable();
            $table->string('file_tdp')->nullable();
            $table->string('file_akta')->nullable();
            $table->string('file_pengesahan')->nullable();
            $table->string('file_izin_praktek')->nullable();
            $table->string('file_slip_gaji')->nullable();
            $table->string('file_rekening_tabungan')->nullable();
            $table->string('file_rekening_koran')->nullable();
            $table->string('file_surat_rekomendasi')->nullable();
            $table->string('file_sk_domisili')->nullable();
            $table->string('file_keterangan_usaha')->nullable();
            $table->string('file_spt')->nullable();
            $table->string('approval_agent')->nullable();
            $table->string('approval_developer')->nullable();
            $table->string('approval_agent_by')->nullable();
            $table->string('approval_developer_by')->nullable();
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
        Schema::dropIfExists('document_clients');
    }
}

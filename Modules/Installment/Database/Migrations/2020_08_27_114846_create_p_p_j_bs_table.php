<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPJBsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppjbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_id');
            $table->date('ppjb_date');
            $table->time('ppjb_time');
            $table->string('location');
            $table->string('address');
            $table->string('status_ppjb');
            $table->string('approval_client_status');
            $table->string('approval_developer_status');
            $table->string('approval_notaris_status');
            $table->string('ppjb_doc_file_name');
            $table->string('ppjb_doc_sign_file_name');
            $table->date('ppjb_sign_date');
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
        Schema::dropIfExists('p_p_j_bs');
    }
}

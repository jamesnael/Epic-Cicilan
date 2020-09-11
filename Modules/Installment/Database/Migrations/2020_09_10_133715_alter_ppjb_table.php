<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPpjbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppjbs', function (Blueprint $table) {
             \DB::select("ALTER TABLE `ppjbs` 
                CHANGE COLUMN `approval_client_status` `approval_client_status`  VARCHAR(191) NULL,
                CHANGE COLUMN `approval_developer_status` `approval_developer_status` VARCHAR(191) NULL ,
                CHANGE COLUMN `approval_notaris_status` `approval_notaris_status`  VARCHAR(191) NULL ,
                CHANGE COLUMN `status_ppjb` `status_ppjb`  VARCHAR(191) NULL ,
                CHANGE COLUMN `ppjb_doc_sign_file_name` `ppjb_doc_sign_file_name`  VARCHAR(191) NULL ;
                ");
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppjbs', function (Blueprint $table) {


        });
    }
}

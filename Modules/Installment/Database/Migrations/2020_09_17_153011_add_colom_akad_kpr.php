<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomAkadKpr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akad_kprs', function (Blueprint $table) {
             $table->double('total_kpr')->nullable()->default(0.00)->after('akad_doc_sign_file_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('akad_kprs', function (Blueprint $table) {
            $table->dropColumn([
                'total_kpr',
            ]);
        });
    }
}

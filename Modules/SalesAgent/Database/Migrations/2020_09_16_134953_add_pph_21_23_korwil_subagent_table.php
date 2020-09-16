<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPph2123KorwilSubagentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->double('ppn', 20, 2)->default(0)->after('pph_final');
            $table->double('pph_21', 20, 2)->default(0)->after('ppn');
            $table->double('pph_23', 20, 2)->default(0)->after('pph_21');
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->double('ppn', 20, 2)->default(0)->after('pph_final');
            $table->double('pph_21', 20, 2)->default(0)->after('ppn');
            $table->double('pph_23', 20, 2)->default(0)->after('pph_21');
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->double('ppn', 20, 2)->default(0)->after('pph_final');
            $table->double('pph_21', 20, 2)->default(0)->after('ppn');
            $table->double('pph_23', 20, 2)->default(0)->after('pph_21');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['ppn', 'pph_21', 'pph_23']);
        });
        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->dropColumn(['ppn', 'pph_21', 'pph_23']);
        });
        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->dropColumn(['ppn', 'pph_21', 'pph_23']);
        });
    }
}

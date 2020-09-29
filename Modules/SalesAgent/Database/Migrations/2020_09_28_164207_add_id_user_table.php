<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
        });

        Schema::table('main_coordinators', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
        });

        Schema::table('regional_coordinators', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}

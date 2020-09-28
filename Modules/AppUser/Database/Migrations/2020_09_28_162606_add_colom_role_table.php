<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->nullable()->after('province');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->longText('user_access')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'status',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_access',
            ]);
        });
    }
}

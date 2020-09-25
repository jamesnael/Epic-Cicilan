<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Installment\Entities\PPJB;
use Modules\Installment\Entities\AkteJualBeli;
use Modules\Installment\Entities\Spr;
use Modules\Installment\Entities\HandOver;
use Modules\DocumentClient\Entities\DocumentClient;


class UpdateAllDataApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('', function (Blueprint $table) {

            PPJB::where('approval_client_status','Approved')->update(['approval_client_status' => 'Disetujui']);
            PPJB::where('approval_developer_status','Approved')->update(['approval_developer_status' => 'Disetujui']);
            PPJB::where('approval_notaris_status','Approved')->update(['approval_notaris_status' => 'Disetujui']);

            AkteJualBeli::where('approval_client_status','Approved')->update(['approval_client_status' => 'Disetujui']);
            AkteJualBeli::where('approval_developer_status','Approved')->update(['approval_Developer_status' => 'Disetujui']);
            AkteJualBeli::where('approval_notaris_status','Approved')->update(['approval_notaris_status' => 'Disetujui']);

            AkteJualBeli::where('approval_client_status','Approved')->update(['approval_client_status' => 'Disetujui']);
            AkteJualBeli::where('approval_developer_status','Approved')->update(['approval_developer_status' => 'Disetujui']);
            AkteJualBeli::where('approval_notaris_status','Approved')->update(['approval_notaris_status' => 'Disetujui']);

            Spr::where('approval_status','Approved')->update(['approval_status' => 'Disetujui']);

            HandOver::where('approval_client_status','Approved')->update(['approval_client_status' => 'Disetujui']);
            HandOver::where('approval_developer_status','Approved')->update(['approval_developer_status' => 'Disetujui']);
            HandOver::where('approval_notaris_status','Approved')->update(['approval_notaris_status' => 'Disetujui']);


            DocumentClient::where('approval_developer','Approved')->update(['approval_developer' => 'Disetujui']);



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

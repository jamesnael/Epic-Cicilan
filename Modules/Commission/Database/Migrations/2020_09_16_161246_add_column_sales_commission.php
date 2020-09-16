<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSalesCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_commissions', function (Blueprint $table) {
            //Korwil Commission
            $table->double('korwil_commission')->nullable()->after('payment_proof_2');
            $table->double('korwil_commission_1')->nullable()->after('korwil_commission');
            $table->date('korwil_payment_date_1')->nullable()->after('korwil_commission_1');
            $table->string('korwil_invoice_commission_1')->nullable()->after('korwil_payment_date_1');
            $table->string('korwil_payment_proof_1')->nullable()->after('korwil_invoice_commission_1');
            $table->double('korwil_commission_2')->nullable()->after('korwil_payment_proof_1');
            $table->date('korwil_payment_date_2')->nullable()->after('korwil_commission_2');
            $table->string('korwil_invoice_commission_2')->nullable()->after('korwil_payment_date_2');
            $table->string('korwil_payment_proof_2')->nullable()->after('korwil_invoice_commission_2');

            //Korut Commission
            $table->double('korut_commission')->nullable()->after('korwil_payment_proof_2');
            $table->double('korut_commission_1')->nullable()->after('korut_commission');
            $table->date('korut_payment_date_1')->nullable()->after('korut_commission_1');
            $table->string('korut_invoice_commission_1')->nullable()->after('korut_payment_date_1');
            $table->string('korut_payment_proof_1')->nullable()->after('korut_invoice_commission_1');
            $table->double('korut_commission_2')->nullable()->after('korut_payment_proof_1');
            $table->date('korut_payment_date_2')->nullable()->after('korut_commission_2');
            $table->string('korut_invoice_commission_2')->nullable()->after('korut_payment_date_2');
            $table->string('korut_payment_proof_2')->nullable()->after('korut_invoice_commission_2');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_commissions', function (Blueprint $table) {

        });
    }
}

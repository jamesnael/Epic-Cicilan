<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_id')->nullable();
            
            $table->double('agency_commission')->nullable();
            $table->double('commission_1')->nullable();
            $table->date('payment_date_1')->nullable();
            $table->string('invoice_commission_1')->nullable();
            $table->string('payment_proof_1')->nullable();
            $table->double('commission_2')->nullable();
            $table->date('payment_date_2')->nullable();
            $table->string('invoice_commission_2')->nullable();
            $table->string('payment_proof_2')->nullable();

            $table->integer('sales_id')->nullable();
            $table->string('sales_name')->nullable();
            $table->double('closing_fee_sales')->nullable();
            $table->string('sales_bank_name')->nullable();
            $table->string('sales_no_rek')->nullable();
            $table->string('sales_bank_account')->nullable();
            $table->date('sales_payment_date')->nullable();
            $table->string('sales_invoice')->nullable();
            $table->string('sales_evidence')->nullable();

            $table->integer('agency_id')->nullable();
            $table->string('agency_name')->nullable();
            $table->double('closing_fee_agency')->nullable();
            $table->date('agency_payment_date')->nullable();
            $table->string('agency_invoice')->nullable();
            $table->string('agency_evidence')->nullable();

            $table->integer('korwil_id')->nullable();
            $table->string('korwil_name')->nullable();
            $table->double('closing_fee_korwil')->nullable();
            $table->date('korwil_payment_date')->nullable();
            $table->string('korwil_invoice')->nullable();
            $table->string('korwil_evidence')->nullable();

            $table->integer('korut_id')->nullable();
            $table->string('korut_name')->nullable();
            $table->double('closing_fee_korut')->nullable();
            $table->date('korut_payment_date')->nullable();
            $table->string('korut_invoice')->nullable();
            $table->string('korut_evidence')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_commissions');
    }
}

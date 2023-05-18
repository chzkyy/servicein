<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_bill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchant');
            $table->string('no_bill'); // nomor tagihan
            $table->string('amount');
            $table->string('proof_of_payment');
            $table->date('bills_date'); // tanggal pembayaran
            $table->string('status');
            $table->string('reason');
            $table->string('approved_by');
            $table->string('rejected_by');
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
        Schema::dropIfExists('merchant_bill');
    }
};

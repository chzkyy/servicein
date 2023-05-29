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
            $table->string('proof_of_payment')->nullable();
            $table->date('bills_date'); // tanggal pembayaran
            $table->string('status')->nullable();
            $table->string('reason')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('rejected_by')->nullable();
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

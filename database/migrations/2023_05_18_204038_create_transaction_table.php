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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('merchant_id')->constrained('merchant');
            $table->string('no_transaction');
            $table->string('status');
            $table->string('user_note');
            $table->string('merchant_note');
            $table->string('service_confirmation');
            $table->string('waranty');
            $table->string('picture');
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
        Schema::dropIfExists('transaction');
    }
};

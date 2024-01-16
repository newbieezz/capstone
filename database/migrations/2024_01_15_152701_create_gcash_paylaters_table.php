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
        Schema::create('gcash_paylaters', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('paylater_id');
            $table->integer('vendor_id');
            $table->integer('user_id');
            $table->integer('payer_id');
            $table->string('payment_proof');
            $table->float('amount',10,2);
            $table->string('payment_status');
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
        Schema::dropIfExists('gcash_paylaters');
    }
};

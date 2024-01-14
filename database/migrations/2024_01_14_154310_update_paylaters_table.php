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
        Schema::table('paylaters', function($table){
            $table->integer('installment_id')->nullable()->change();
            $table->integer('installment_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paylaters', function($table){
            $table->integer('installment_id')->change();
            $table->dropColumn('installment_week')->change();
        });
    }
};

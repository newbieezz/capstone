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
        Schema::create('pay_later_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('work');//source of fund / job
            $table->string('salary'); //monthly salary
            $table->string('valid_id');//valid id picture
            $table->string('selfie');//selfie with valid id
            $table->tinyInteger('appstatus');
            $table->integer('garantor_id');
            $table->integer('garantor_name');
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
        Schema::dropIfExists('pay_later_applications');
    }
};

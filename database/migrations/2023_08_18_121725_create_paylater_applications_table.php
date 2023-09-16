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
            $table->date('dob')->nullable(); //date of birth
            $table->string('pob');//place of birth
            $table->string('sof');//source of fund
            $table->string('comp_name');//company name
            $table->string('income');
            $table->string('valid_id');//valid id picture
            $table->string('selfie');//selfie with valid id
            $table->string('emerCon_name');//emergency contact name
            $table->string('emerCon_mobile');//contact number
            $table->string('relationship');
            $table->tinyInteger('appstatus');
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
        Schema::dropIfExists('paylater_applications');
    }
};

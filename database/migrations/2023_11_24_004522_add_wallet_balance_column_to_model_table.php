<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->decimal("wallet_balance", 16, 2)->default(0);
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->decimal("wallet_balance", 16, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumns("wallet_balance");
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumns("wallet_balance");
        });
    }
};

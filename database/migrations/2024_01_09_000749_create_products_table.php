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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');//which section it belongs
            $table->integer('category_id');//which category does it belong
            $table->integer('brand_id');//which brand it is
            $table->integer('vendor_id');//which vendor it belongs
            $table->integer('admin_id');
            $table->string('admin_type');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_price');
            $table->string('selling_price');
            $table->decimal('markup', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('restock_threshold')->nullable();
            $table->integer('sales_quantity')->default(0);
            $table->decimal('total_revenue', 10, 2)->default(0.00);
            $table->timestamp('sold_at')->nullable();
            $table->string('product_discount')->nullable();
            $table->string('product_image')->nullable();
            $table->string('description')->nullable();
            $table->enum('is_featured',['No','Yes']); //if featured/displayin or not
            $table->tinyInteger('status');//active or inactive
            $table->string('weight')->nullable();
            $table->string('volume')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
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
        Schema::dropIfExists('products');
    }
};

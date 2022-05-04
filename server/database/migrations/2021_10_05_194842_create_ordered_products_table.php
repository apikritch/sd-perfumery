<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_products', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->text('image')->nullable();
            $table->string('title')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->integer('size')->nullable();
            $table->string('gender')->nullable();
            $table->double('price')->nullable();
            $table->string('discount')->nullable();
            $table->double('discount_number')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('final_price')->nullable();
            $table->double('total')->nullable();
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
        Schema::dropIfExists('ordered_products');
    }
}

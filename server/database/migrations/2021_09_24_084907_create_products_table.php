<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->text('image')->nullable();
            $table->string('title')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('gender')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->nullable();
            $table->double('price')->nullable();
            $table->string('discount')->nullable();
            $table->double('discount_number')->nullable();
            $table->double('final_price')->nullable();
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
}

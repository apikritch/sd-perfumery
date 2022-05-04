<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total_saving')->nullable();
            $table->string('shipping_method')->nullable();
            $table->double('shipping_fee')->nullable();
            $table->double('order_total')->nullable();
            $table->string('payment_bank')->nullable();
            $table->string('payment_account_name')->nullable();
            $table->string('payment_account_detail')->nullable();
            $table->string('order_date')->nullable();
            $table->string('order_time')->nullable();
            $table->string('order_status')->nullable();
            $table->string('shippment_status')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('notification')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orderId');
            $table->foreign('orderId')->references('id')->on('orders');
            $table->string('discountReason');
            $table->decimal('discountAmount');
            $table->decimal('subtotal');
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
        Schema::dropIfExists('ordered_discounts');
    }
}

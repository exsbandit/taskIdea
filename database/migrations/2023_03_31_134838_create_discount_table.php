<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['order', 'customer', 'category', 'product'])->comment('
                Order ise order ın total price ına uygulanır.
                Customer ise order ın tamamına uygulanır.
                Category ise order altındaki ilgili category nin totaline uygulanır
                Product ise İlgili orderın altındaki product totaline uygulanır
            ');
            $table->string('selection')->nullable();
            $table->string('description')->comment('Discount description');
            $table->enum('control_unit', ['amount', 'quantity', 'none'])->default('none')->comment('
                   Kıyas yapılacak durum
                   Orn 1000 TL üzeri alışveriş, 6 üzeri ürün
            ');
            $table->enum('discount_unit', ['percentage', 'amount', 'quantity']);
            $table->enum('rule', ['equal', 'upper', 'lower', 'none'])->default('none');
            $table->string('controlTable')->nullable();
            $table->string('controlColumn')->nullable();
            $table->string('control')->nullable();
            $table->integer('input')->nullable()->comment('indirim miktarı / adedi / yüzdesi');
            $table->float('case')->nullable();
            $table->boolean('status')->default(true);
            $table->date('lastDate')->default(\Carbon\Carbon::now()->addYear()->toDateString());
            $table->integer('remaining')->default(-1);
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
        Schema::dropIfExists('discounts');
    }
}

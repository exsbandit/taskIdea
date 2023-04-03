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
            $table->string('name');
            $table->string('description')->comment('Discount description can be insert that column');
            $table->integer('type')->comment('Discount only applied to products, categories and cart(total)');
            $table->boolean('is_percentage')->comment('Discount must be unit or percentage');
            $table->float('discount')->comment('Discount unit(%10, ');
            $table->boolean('status');
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


/*

sepet mi adet mi = hayır / evet
kategori mi = evet
ürün mü = hayır
yüzde mi = evet
indirim miktarı = 20
Status = active



Hayır, Hayır, Hayır, Hayır, 100
Ürün alımına 100 TL inidirim

Hayır, Evet, Hayır, Evet, 100
X nolu kategoriden alışverişşinize %Y indirim

Hayır, Evet, Hayır, Evet, 100
X nolu kategoriden alışverişşinize %Y indirim



*/



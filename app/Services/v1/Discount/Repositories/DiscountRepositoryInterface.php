<?php


namespace App\Services\v1\Discount\Repositories;


use Illuminate\Database\Eloquent\Model;

interface DiscountRepositoryInterface
{
    /*
    Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.
    2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.
    1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.
    */

    public function cartDiscount(Model $order, $attributes);

    public function moreThanValue(Model $model, array $attributes): Model;

    public function checkCartDiscount($discount, $order);

    public function checkCustomerDiscount($discount, $order);

    public function checkProductDiscount($discount, $order);

    public function checkCategoryDiscount($discount, $order);
}

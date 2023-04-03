<?php
namespace App\Services\v1\Order\Helpers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Ramsey\Collection\Collection;

class Discount
{
    public static function checkCartDiscount(Collection $orderedProducts): string
    {
        foreach ($orderedProducts as $product) {
            //$this->buyXgetY($product);

        }


        // EVAL KULLANILABİLİR
        // if cart is false

        // else
        // items countlarını category e göre grouplayıp bakılabilir
        // falan filenler



    }

    private function totalCartDiscount() {

    }

    /*private function buyXgetY($product) {

        $checkedProduct = Product::find($product->id)->get();

        if ($checkProductDiscount = Discount::find($checkedProduct->category)) {
            if ($product->quantity > $checkProductDiscount->quantitiy) {
                $discounted = [
                    'discountReason' => $checkProductDiscount->name,
                    'discountAmount' => (($product->quantity / X) * Y) * $checkedProduct->price,
                ]
            }
        }

    }*/

    private function buyNDiscountM() {

    }
}

<?php

namespace App\Services\v1\Discount\Repositories;

use App\Models\Discount;
use App\Models\Order;
use App\Repositories\v1\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use function Nette\Utils\match;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    public function __construct(Discount $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $models = $this->toModel($attributes['type']);

        $dir = '../app/Models';
        $files = scandir($dir);
        foreach ($models as $model) {
            if (!in_array($model . '.php', $files)) {
                throw ValidationException::withMessages(['type' => $model . ' is not a model, check your attributes']);
            }
        }
/*
      {
            'type': 'customer',
            'selection': '1' //customer id
            'desc': 'hoşgeldin indirimi',
            'unit': 'price', // percentage,
            'rule': 'lower',
            'control': '2022.04.10',
            'input': '20',
        }
        */


        $order = Order::where('id',1)->get();

        $this->discountFinder($attributes, $order);


        return $this->model::query()->create($attributes);
    }

    public function discountFinder($order): array|bool
    {
        // Discount Controlleri Sırayla
        // Product discountları kontrol edilir
        // Category discountları kontrol edilir
        // Customer discountları kontrol edilir
        // Order discountları kontrol edilir

        $discounts = Discount::orderByRaw("FIELD(type , 'product', 'category', 'customer', 'order') ASC")->get();
        $discountResult = [];
        $totalDiscount = 0;
        foreach ($discounts as $discount) {
            $discountResult[] = match($discount['type']){
            'cart' => $this->checkCartDiscount($discount, $order),
            'customer' => $this->checkCustomerDiscount($discount, $order),
            'product' => $this->checkProductDiscount($discount, $order),
            'category' => $this->checkCategoryDiscount($discount, $order),
        };
        }

        $result = json_encode([
            "orderId" => $order->id,
            "discounts" => $discountResult,
            "totalDiscount" => $totalDiscount,
            "discountedTotal" => $order->total - $totalDiscount

        ]);
        return $result;
    }

    /**
     * Calculate the discount amount and subtotal based on cart rules.
     *
     * @param  array  $discount
     * @param  \App\Models\Order  $order
     * @return array|null
     */
    public function checkCartDiscount($discount, $order)
    {
        if ($discount['controlColumn'] !== 'total') {
            return null;
        }

        $subtotal = $order->total;
        $discountAmount = 0;

        if ($discount['rule'] === 'lower' && $subtotal < $discount['sub_total']) {
            return null;
        } elseif ($discount['rule'] === 'upper' && $subtotal > $discount['sub_total']) {
            $discountAmount = $subtotal * $discount['input'] / 100;
        } else {
            return null;
        }

        return [
            'discountReason' => $discount['desc'],
            'discountAmount' => $discountAmount,
            'subtotal' => $subtotal - $discountAmount,
        ];
    }

    /**
     * Calculate the discount amount and subtotal based on customer rules.
     *
     * @param  array  $discount
     * @param  \App\Models\Order  $order
     * @return array|null
     */
    public function checkCustomerDiscount($discount, $order)
    {
        if ($discount['controlColumn'] !== 'customer_id') {
            return null;
        }

        if ($order->customer_id != $discount['control']) {
            return null;
        }



        $subtotal = $order->total;
        $discountAmount = 0;

        if ($discount['rule'] === 'lower' && $subtotal < $discount['sub_total']) {
            return null;
        } elseif ($discount['rule'] === 'upper' && $subtotal > $discount['sub_total']) {
            $discountAmount = $subtotal * $discount['input'] / 100;
        } else {
            return null;
        }

        return [
            'discountReason' => $discount['desc'],
            'discountAmount' => $discountAmount,
            'subtotal' => $subtotal - $discountAmount,
        ];
    }

    public function checkProductDiscount($discount, $order)
    {
        if (!$this->controlSelection($discount, $order, 'productId')) {
            return null;
        }

        if ($discount['control_unit'] == 'amount') {
            $selectionIds = explode(',', $discount['selection']);
            $totalPrice = 0;
            foreach ($selectionIds as $id) {
                $totalPrice += $order->products->find($id)->total;
            }

            $caseStatus = $discount['case'] == 'upper' ?
                $totalPrice > $discount['case'] : ($discount['case'] == 'lower' ?
                $totalPrice < $discount['case'] :
                $totalPrice == $discount['case']
            );

            if ($caseStatus) {
                $this->calculateDiscount($discount, $order);
            }
        }

        if ($discount['controlColumn'] == 'product_id') {
            $products = collect($order->items)->where('productId', $discount['control']);
            $totalProduct = $products->sum('quantity');
            if ($totalProduct > 0) {
                $discountAmount = $this->calculateDiscount($totalProduct, $discount['input'], $discount['unit'], $discount['rule']);
                $total = $order->total - $discountAmount;
                $result = [
                    "discountReason" => $discount['desc'],
                    "discountAmount" => $discountAmount,
                    "subtotal" => $total
                ];
                $this->addToTotalDiscount($discountAmount);
                return $result;
            }
        }
        return null;
    }


    public function checkCategoryDiscount($discount, $order)
    {
        if ($discount['controlColumn'] == 'category_id') {
            $products = collect($order->items)->whereIn('categoryId', explode(',', $discount['control']));
            $totalProduct = $products->sum('quantity');
            if ($totalProduct > 0) {
                $discountAmount = $this->calculateDiscount($totalProduct, $discount['input'], $discount['unit'], $discount['rule']);
                $total = $order->total - $discountAmount;
                $result = [
                    "discountReason" => $discount['desc'],
                    "discountAmount" => $discountAmount,
                    "subtotal" => $total
                ];
                $this->addToTotalDiscount($discountAmount);
                return $result;
            }
        }
        return null;
    }

    public function calculateDiscount($discount, $order, $productPrice = null)
    {
        if ($discount['discount_unit'] == 'percentage') {
            $subtotal = $order->total * ($discount['input'] / 100);
            return [
                "discountReason" => $discount['desc'],
                "discountAmount" => $order->total - $subtotal,
                "subtotal" => $subtotal
            ];
        } else if ($discount['discount_unit'] == 'amount') {
            $subtotal = $order->total - $discount['input'];
            return [
                "discountReason" => $discount['desc'],
                "discountAmount" => $order->total - $subtotal,
                "subtotal" => $subtotal
            ];
        } else if ($discount['discount_unit'] == 'quantity') {
            $subtotal = $productPrice * $discount['input'];
            return [
                "discountReason" => $discount['desc'],
                "discountAmount" => $order->total - $subtotal,
                "subtotal" => $subtotal
            ];
        }

        $discountAmount = 0;
        if ($discount['discount_unit'] == 'percentage') {
            $discountAmount = $discount['input'] * ($discount / 100);
            if ($discount['rule'] == 'upper') {
                if ($discountAmount > $discount) {
                    $discountAmount = $discount;
                }
            } else {
                if ($discountAmount < $discount) {
                    $discountAmount = $discount;
                }
            }
        } else {
            $discountAmount = ($discount['rule'] / $discount) * $discount;
        }

        $result = [
            "discountReason" => $discount['desc'],
            "discountAmount" => $discountAmount,
            "subtotal" => '$total'
        ];
        $this->addToTotalDiscount($discountAmount);
        return $result;
    }

    /**
     * @param $discount
     * @param $order
     * @param $check
     * @return bool
     * Check parameters possibilities categoryId, productId
     */
    private function controlSelection($discount, $order, $check): bool
    {
        $orderControl = $order->products->pluck($check)->toArray();
        $selectionIds = explode(',', $discount['selection']);

        foreach ($selectionIds as $id) {
            if (!in_array($id, $orderControl)) {
                return false;
            }
        }
        return true;
    }

    public function cartDiscount(Model $order, $attributes): Model
    {

    }

    public function moreThanValue(Model $model, array $attributes): Model
    {

    }

}

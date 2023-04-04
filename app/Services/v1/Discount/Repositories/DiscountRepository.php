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
            "type":[
            "customer",
            "product"
        ],
            "selection": [1,3],
            "desc": "hoşgeldin indirimi",
            "unit": "price",
            "rule": "lower",
            "control": "2022-04-10",
            "input": "20"
        }
        */


        $order = Order::find(1)->get();

        dd($order);
        dd(App::make('App/Model/Customer'));
        dd(  $collection = new ('App\Model\Customer'));
        dd($baseClass);
        return $this->model::query()->create($attributes);
    }

    public function discountFinder($attribute): array | bool
    {


        return match($attribute['mainKey']) {
            'cart' => $this->checkCartDiscount($attribute),
            'customer' => $this->checkCustomerDiscount($attribute),
            'product' => $this->checkProductDiscount($attribute),
            'category' => $this->checkCategoryDiscount($attribute),
        };
    }

    public function checkCartDiscount($attribute)
    {
        /*
            {
                "type": "customer",
                "selection": "1",
                "desc": "hoşgeldin indirimi",
                "unit": "price",
                "rule": "lower",
                "control": "2022-04-10",
                "input": "20"
            }
        */

       /* match($attribute['rule']){
            'greater' => $cart->total >= $attribute['target'] ? ['total' => $cart->total * (100)] : $cart->total,
            'unit' => function () use ($cart, $attribute) {
                $productCount = $this->productCounter($attribute);

                $cart->items
            },
        };*/

        dd('wait');

        return ['checkCartDiscount'=> true];
    }

    public function checkCustomerDiscount($attribute)
    {
        return ['checkCustomerDiscount'=> true];
    }

    public function checkProductDiscount($attribute)
    {
        return ['checkProductDiscount'=> true];
    }

    public function checkCategoryDiscount($attribute)
    {
        return ['checkCategoryDiscount'=> true];
    }


    public function cartDiscount(Model $order, $attributes): Model
    {

    }

    public function moreThanValue(Model $model, array $attributes): Model
    {

    }

    public function productCounter($order): int
    {
        $counter = 0;
        foreach ($order->items as $item) {
            $counter += $item->quantity;
        }
        return $counter;
    }

    protected function getCalculationValue($input)
    {
        preg_match('/([0-9.]+)$|([0-9]+)/', $input, $matches);

        return $matches[0];
    }

    /**
     * Determine if condition is percentage
     *
     * @param  string  $input
     * @return boolean
     */
    protected function isPercentage($input)
    {
        return S::contains($input, '%');
    }

    protected function toModel($models){

        $modelArr = [];
        foreach ($models as $stringmodel) {
            $modelArr[] = ucfirst(strtolower($stringmodel));
        }
        return $modelArr;
    }

}

<?php

namespace App\Services\v1\Order\Repositories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderedDiscount;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Repositories\v1\Base\BaseRepository;
use Carbon\Carbon;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;
use Illuminate\Database\Eloquent;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function prepareFilters(Builder $query, array $filters): Builder
    {
        if (isset($filters['name'])) {
            $query->where('name', 'LIKE', "{$filters['name']}%");
            unset($filters['name']);
        }

        return parent::prepareFilters($query, $filters);
    }


    public function orderedProducts(): Collection
    {
        $orderedProducts = OrderedProduct::groupBy('orderId')->pluck('orderId');
        return Order::query()
            ->whereIn('id', $orderedProducts)
            ->get();
    }

    public function orderedDiscounts(): Collection
    {
        $orderedDiscounts = OrderedDiscount::groupBy('orderId')->pluck('orderId');
        return Order::query()
            ->whereIn('id', $orderedDiscounts)
            ->get();
    }

    public function create(array $attributes): Model
    {
        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $order = $this->model::firstOrCreate([
                'customerId' => $attributes['customerId'],
                'total' => 0,
            ]);
            foreach ($attributes['products'] as $product) {
                $orderedProduct = Product::find($product['id']);
                $totalPrice += $this->dropStock($orderedProduct, $order, $product['quantity']);

            }
            $order->total = $totalPrice;
            $order->save();

            Customer::where('id', $attributes['customerId'])
                ->increment('revenue', $totalPrice);
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    private function dropStock(Model $orderedProduct, $order, $quantity): float
    {
        DB::beginTransaction();
        try {
            $orderedProduct->stock = $orderedProduct->stock - $quantity;
            $orderedProduct->save();

            $checkDiscount = $this->checkDiscount();
            OrderedProduct::create([
                'orderId' => $order->id,
                'productId' => $orderedProduct->id,
                'quantity' => $quantity,
                'unitPrice' => $orderedProduct->price,
                'total' => $orderedProduct->price * $quantity,
            ]);
            DB::commit();
            return $orderedProduct->price * $quantity;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    private function checkDiscount()
    {

    }
}

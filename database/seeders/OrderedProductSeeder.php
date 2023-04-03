<?php


namespace Database\Seeders;

use App\Models\OrderedProduct;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderedProduct::create(
            [
                'id' => 1,
                'orderId' => 1,
                "productId" => 102,
                'quantity' => 10,
                'unitPrice' => 11.28,
                'total' => 112.80,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        OrderedProduct::create(
            [
                'id' => 2,
                'orderId' => 2,
                "productId" => 101,
                'quantity' => 2,
                'unitPrice' => 49.50,
                'total' => 99.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        OrderedProduct::create(
            [
                'id' => 3,
                'orderId' => 2,
                "productId" => 100,
                'quantity' => 1,
                'unitPrice' => 120.75,
                'total' => 120.75,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        OrderedProduct::create(
            [
                'id' => 4,
                'orderId' => 3,
                "productId" => 102,
                'quantity' => 6,
                'unitPrice' => 11.28,
                'total' => 67.68,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        OrderedProduct::create(
            [
                'id' => 5,
                'orderId' => 3,
                "productId" => 100,
                'quantity' => 10,
                'unitPrice' => 120.75,
                'total' => 1207.50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

    }
}

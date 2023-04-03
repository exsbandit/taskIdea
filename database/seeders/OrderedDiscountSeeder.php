<?php


namespace Database\Seeders;

use App\Models\OrderedDiscount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderedDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderedDiscount::create(
            [
                'id' => 1,
                'orderId' => 1,
                "discountReason" => "BUY_5_GET_1",
                'discountAmount' => 11.28,
                'subtotal' => 1263.90,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

        OrderedDiscount::create(
            [
                'id' => 2,
                'orderId' => 1,
                "discountReason" => "10_PERCENT_OVER_1000",
                'discountAmount' => 127.51,
                'subtotal' => 1136.39,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}

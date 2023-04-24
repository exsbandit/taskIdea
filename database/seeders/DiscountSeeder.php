<?php


namespace Database\Seeders;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discount::create(
            [
                "type" => "customer",
                "selection" => "1",
                "description" => "1 id li müşteriye alışverişlerinde %5 indirim",
                "control_unit" => "none",
                "discount_unit" => "percentage",
                "rule" => "upper",
                "input" => 5, // indirim miktarı
                "status" => true,
                "lastDate" => Carbon::now()->addDays(50)->toDateString(),
                "remaining" => -1,
            ]
        );

        Discount::create(
            [
                "type" => "order",
                "selection" => "1",
                "description" => "500 tl üstü alışverişlere %10 indirim",
                "control_unit" => "amount",
                "discount_unit" => "percentage",
                "rule" => "upper",
                "input" => 10,
                "case" => 500,
                "status" => true,
                "lastDate" => Carbon::now()->addDays(50)->toDateString(),
                "remaining" => 50,
            ]
        );
        Discount::create(
            [
                "type" => "customer",
                "selection" => "2",
                "description" => "2 id li customer a 2 idli category alışverişlerinde 100Tl indirim",
                "controlTable" => "categories",
                "controlColumn" => "id",
                "control" => "2",
                "control_unit" => "quantity",
                "rule" => 'upper',
                "case" => 0,
                "discount_unit" => "amount",
                "input" => 100,
            ]
        );
        Discount::create(
            [
                "type" => "customer",
                "selection" => "3",
                "description" => "3 id li customer a 3 idli category alışverişlerinde 6 al 5 öde",
                "control_unit" => "quantity",
                "discount_unit" => "quantity",
                "controlTable" => "categories",
                "controlColumn" => "id",
                "control" => "3",
                "rule" => "upper",
                "case" => 5,
                "input" => 1,
                "status" => true,
                "lastDate" => Carbon::now()->addDays(50)->toDateString(),
                "remaining" => 50,
            ]
        );

        Discount::create(
            [
                "type" => "category",
                "selection" => "1",
                "description" => "1 idli category alışverişlerinde 2 al 1 öde",
                "control_unit" => "quantity",
                "discount_unit" => "quantity",
                "rule" => "upper",
                "case" => 1,
                "input" => 1,
            ]
        );


        Discount::create(
            [
                "type" => "product",
                "selection" => "100",
                "description" => "100 idli ürün alışverişlerinde 5 ve üzeri alışverişe en ucuza %20 indirim",
                "control_unit" => "quantity",
                "discount_unit" => "percentage",
                "rule" => "upper",
                "case" => 4,
                "input" => 20,
            ]
        );
    }
}



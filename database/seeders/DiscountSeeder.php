<?php


namespace Database\Seeders;

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
        $discounts = array(
            array(
                'id' => '1',
                'name' => 'BUY_5_GET_1',
                'description' => 'Category 2 den alınan aynı 6 üründen 1 i ücretsiz',
                'type' => 1,
                'is_percentage' => false,
                'discount' => 5,
                'status' => 1,
            ),
            array(
                'id' => '2',
                'name' => '10_PERCENT_OVER_1000',
                'description' => 'Toplamda yapılan 1000 ve üzeri alışverişlere %10 indirim',
                'type' => 1,
                'is_percentage' => false,
                'discount' => 5,
                'status' => 1,
            ),
            array(
                'id' => '3',
                'name' => 'MIN_2_LOW_PRODUCT_10',
                'description' => 'Category 1 den alınan 2 ve üzeri alışverişlerde en ucuz ürüne %20 indirim',
                'type' => 1,
                'is_percentage' => false,
                'discount' => 5,
                'status' => 1,
            ),
        );

        DB::table('discounts')->insert($discounts);
    }
}

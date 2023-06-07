<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        Coupon::factory(11)->create();
    }
}

<?php

namespace Modules\Coupon\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Coupon\Entities\Coupon;

class CouponDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        Coupon::factory(11)->create();
    }
}

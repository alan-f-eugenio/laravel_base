<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\ProductAttribute;

class ProductAttributeTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        ProductAttribute::factory(2)->create();
    }
}

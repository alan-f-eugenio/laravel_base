<?php

namespace Modules\Product\Database\Seeders;

use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class ProductDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        if (File::isDirectory(storage_path('app') . '/public/products')) {
            File::cleanDirectory(storage_path('app') . '/public/products');
        } else {
            File::makeDirectory(storage_path('app') . '/public/products', 0755, true, true);
        }

        Product::factory(11)->create();
    }
}

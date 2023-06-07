<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        if (File::isDirectory(storage_path('app') . '/public/products')) {
            File::cleanDirectory(storage_path('app') . '/public/products');
        } else {
            File::makeDirectory(storage_path('app') . '/public/products', 0755, true, true);
        }

        Product::factory(11)->create();
    }
}

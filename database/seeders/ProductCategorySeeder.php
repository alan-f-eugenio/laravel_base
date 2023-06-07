<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        if (File::isDirectory(storage_path('app') . '/public/product_categories')) {
            File::cleanDirectory(storage_path('app') . '/public/product_categories');
        } else {
            File::makeDirectory(storage_path('app') . '/public/product_categories', 0755, true, true);
        }

        ProductCategory::factory(2)
            ->sequence(fn ($sequence) => ['ordem' => $sequence->index + 1])
            ->create([
                'id_parent' => ProductCategory::factory()
                    ->sequence(fn ($sequence) => ['ordem' => $sequence->index + 1])
                    ->create(),
            ]);
    }
}

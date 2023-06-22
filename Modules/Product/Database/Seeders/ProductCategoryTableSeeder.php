<?php

namespace Modules\Product\Database\Seeders;

use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\ProductCategory;

class ProductCategoryTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

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

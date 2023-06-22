<?php

namespace Modules\Product\Database\Seeders;

use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\ProductAttribute;
use Modules\Product\Entities\ProductAttributeOpt;

class ProductAttributeOptTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        if (File::isDirectory(storage_path('app') . '/public/product_attribute_opts')) {
            File::cleanDirectory(storage_path('app') . '/public/product_attribute_opts');
        } else {
            File::makeDirectory(storage_path('app') . '/public/product_attribute_opts', 0755, true, true);
        }

        ProductAttributeOpt::factory(3)
            ->sequence(fn ($sequence) => ['ordem' => $sequence->index + 1])
            ->create([
                'product_attribute_id' => ProductAttribute::factory()->create([
                    'has_files' => 1,
                ]),
                'filename' => 'product_attribute_opts/' . fake()->image(storage_path('app') . '/public/product_attribute_opts', 50, 50, null, false),
            ]);
        ProductAttributeOpt::factory(3)
            ->sequence(fn ($sequence) => ['ordem' => $sequence->index + 1])
            ->create([
                'product_attribute_id' => ProductAttribute::factory()->create(),
            ]);
    }
}

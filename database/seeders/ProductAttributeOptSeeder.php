<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeOpt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductAttributeOptSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //

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

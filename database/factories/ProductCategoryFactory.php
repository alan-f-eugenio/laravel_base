<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
$name = fake()->words(3, true);

        return [
            //
            'name' => $name,
            'slug' => Str::slug($name),
            'text' => fake()->boolean() ? fake()->paragraph(3) : null,
            'filename' => 'product_categories/' . fake()->image(storage_path('app') . '/public/product_categories', 1200, 300, null, false),
        ];
    }
}

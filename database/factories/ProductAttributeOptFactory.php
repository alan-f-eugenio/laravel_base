<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributeOpt>
 */
class ProductAttributeOptFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            //
            'name' => fake()->unique()->word(),
            // 'filename' => "product_categories/" . fake()->image(storage_path('app') . "/public/product_categories", 1200, 300, null, false),
        ];
    }
}

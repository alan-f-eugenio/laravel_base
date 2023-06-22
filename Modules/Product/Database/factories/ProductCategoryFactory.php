<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategoryFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Entities\ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $name = fake()->words(3, true);

        return [
            //
            'name' => $name,
            'slug' => str($name)->slug(),
            'text' => fake()->boolean() ? fake()->paragraph(3) : null,
            'filename' => 'product_categories/' . fake()->image(storage_path('app') . '/public/product_categories', 1200, 300, null, false),
        ];
    }
}

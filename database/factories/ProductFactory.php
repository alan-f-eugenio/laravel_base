<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $bool = fake()->boolean(75);
        $name = fake()->words(2, true);
        $price = fake()->randomFloat(2, 0.01, 9999.99);
        $inPromoBool = fake()->boolean(25);
        $promo_date_in = fake()->dateTimeBetween('now', '1 year');

        return [
            //
            'type' => $bool ? 1 : 2,
            'sku' => fake()->unique()->bothify('#?#?#?'),
            'name' => $name,
            'slug' => Str::slug($name),
            'weight' => $bool ? fake()->randomFloat(2, 0.01, 9999.99) : null,
            'width' => $bool ? fake()->randomFloat(2, 0.01, 9999.99) : null,
            'height' => $bool ? fake()->randomFloat(2, 0.01, 9999.99) : null,
            'depth' => $bool ? fake()->randomFloat(2, 0.01, 9999.99) : null,
            'stock' => $bool ? fake()->numberBetween(0, 999) : null,
            'price' => $bool ? $price : null,
            'price_cost' => $bool ? fake()->randomFloat(2, 0.01, $price) : null,
            'promo_value' => $bool && $inPromoBool ? fake()->randomFloat(2, 0.01, $price) : null,
            'promo_date_in' => $bool && $inPromoBool ? $promo_date_in : null,
            'promo_date_end' => $bool && $inPromoBool ? fake()->dateTimeBetween($promo_date_in, '2 years') : null,
        ];
    }
}

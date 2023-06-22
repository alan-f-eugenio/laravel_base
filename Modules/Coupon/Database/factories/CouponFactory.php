<?php

namespace Modules\Coupon\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Coupon\Entities\Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $bool = fake()->boolean();
        $bool2 = fake()->boolean();
        $bool3 = fake()->boolean();
        $date_start = fake()->dateTimeBetween('now', '1 year');
        $value_min = fake()->randomFloat(2, 0.01, 9999.99);
        $value_max = fake()->randomFloat(2, $value_min, 9999.99);

        return [
            //
            'token' => fake()->word(),
            'description' => fake()->words(3, true),
            'qtd' => fake()->randomNumber(3),
            'date_start' => $bool ? $date_start : null,
            'date_end' => $bool ? fake()->dateTimeBetween($date_start, '2 years') : null,
            'value_min' => $bool2 ? $value_min : null,
            'value_max' => $bool2 ? $value_max : null,
            'discount' => $bool3 ? fake()->randomFloat(2, $value_max, 9999.99) : fake()->randomNumber(2),
            'discount_type' => $bool3 ? 2 : 1,
            'first_buy' => (int) fake()->boolean(),
        ];
    }
}

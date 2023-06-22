<?php

namespace Modules\Email\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Email\Entities\Email::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}

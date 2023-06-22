<?php

namespace Modules\Content\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentNavFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Content\Entities\ContentNav::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $title = fake()->words(2, true);

        return [
            'title' => str($title)->title(),
            'slug' => str($title)->slug(),
        ];
    }
}

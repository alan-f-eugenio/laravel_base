<?php

namespace Modules\Banner\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerLocalFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Banner\Entities\BannerLocal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            //
            'title' => str(fake()->words(2, true))->title(),
        ];
    }
}

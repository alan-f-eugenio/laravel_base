<?php

namespace Modules\Banner\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Banner\Entities\Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'title' => str(fake()->word())->title(),
            'filename' => 'banners/' . fake()->image(storage_path('app') . '/public/banners', 1200, 300, null, false),
        ];
    }
}

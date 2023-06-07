<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        static $number = 1;
        static $number2 = 1;
        static $bool;

        return [
            //
            // 'local_id' => $bool ? 1 : 2,
            'title' => Str::title(fake()->word()),
            // 'ordem' => $bool ? $number++ : $number2++,
            'filename' => 'banners/' . fake()->image(storage_path('app') . '/public/banners', 1200, 300, null, false),
        ];
    }
}

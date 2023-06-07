<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentNav>
 */
class ContentNavFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {

        $title = fake()->words(2, true);
        // $boolType = fake()->boolean(75);

        return [
            //
            'title' => Str::title($title),
            'slug' => Str::slug($title),
            // 'type' => $boolType ? 1 : 2
        ];
    }
}

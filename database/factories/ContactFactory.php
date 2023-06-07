<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        // $boolenOptional = fake()->boolean(50);
        $boolSeen = fake()->boolean(25);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'subject' => Str::title(fake()->words(3, true)),
            'message' => fake()->paragraphs(3, true),
            'seen' => (int) $boolSeen,
            // 'cro' => fake()->optional($boolenOptional)->randomNumber(5, true),
            // 'qtd' => fake()->optional($boolenOptional)->randomNumber(3),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $bool = fake()->boolean(75);

        return [
            //
            'person' => $bool ? 1 : 2,
            'fullname' => $bool ? fake()->name() : Str::title(fake()->words(2, true)),
            'cpf' => $bool ? fake()->numerify('###.###.###-##') : null,
            'rg' => $bool ? fake()->numerify(fake()->boolean() ? '#.###.###-#' : '##.###.###-##') : null,
            'date_birth' => $bool ? fake()->dateTimeBetween('-100 years', '-18 years') : null,
            'cnpj' => !$bool ? fake()->numerify('##.###.###/0001-##') : null,
            'corporate_name' => !$bool ? Str::title(fake()->words(2, true)) : null,
            'state_registration' => !$bool ? fake()->numerify('###.#####-##') : null,
            'phone' => fake()->numerify('(##) 9####-####'),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Define>
 */
class DefineFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            //
            'page_title' => Str::title(fake()->word()),
            'company_name' => Str::title(fake()->words(2, true)),
            'company_corporate_name' => Str::title(fake()->words(3, true)),
            'company_email' => fake()->safeEmail(),
            'company_cep' => fake()->numerify('#####-###'),
            'company_cnpj' => fake()->numerify('##.###.###/0001-##'),
            'company_phone' => fake()->numerify('(##) ####-####'),
            'company_whats' => fake()->numerify('(##) 9####-####'),
        ];
    }
}

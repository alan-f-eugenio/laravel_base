<?php

namespace Database\Factories;

use Faker\Provider\pt_BR\Address as BrAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerAddress>
 */
class CustomerAddressFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $bool = fake()->boolean();

        return [
            //
            'recipient' => fake()->name(),
            'cep' => fake()->numerify('#####-###'),
            'street' => fake()->streetName(),
            'number' => BrAddress::buildingNumber(),
            'complement' => $bool ? BrAddress::secondaryAddress() : '',
            'neighborhood' => Str::title(fake()->words(3, true)),
            'city' => fake()->city(),
            'state' => BrAddress::stateAbbr(),
        ];
    }
}

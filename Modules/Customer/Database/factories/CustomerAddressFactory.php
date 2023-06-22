<?php

namespace Modules\Customer\Database\factories;

use Faker\Provider\pt_BR\Address as BrAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerAddressFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Customer\Entities\CustomerAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $bool = fake()->boolean();

        return [
            'recipient' => fake()->name(),
            'cep' => fake()->numerify('#####-###'),
            'street' => fake()->streetName(),
            'number' => BrAddress::buildingNumber(),
            'complement' => $bool ? BrAddress::secondaryAddress() : '',
            'neighborhood' => str(fake()->words(3, true))->title(),
            'city' => fake()->city(),
            'state' => BrAddress::stateAbbr(),
        ];
    }
}

<?php

namespace Modules\Contact\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Contact\Entities\Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'subject' => str(fake()->words(3, true))->title(),
            'message' => fake()->paragraphs(3, true),
        ];
    }
}

<?php

namespace Modules\Content\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Content\Entities\Content::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $title = fake()->words(2, true);

        return [
            'title' => str($title)->title(),
            'slug' => str($title)->slug(),
            'text' => '<p>' . implode('</p><p>', fake()->paragraphs(2)) . '</p>',
            'abstract' => '<p>' . fake()->paragraph(1) . '</p>',
            'filename' => 'contents/' . fake()->image(storage_path('app') . '/public/contents', 300, 300, null, false),
        ];
    }
}

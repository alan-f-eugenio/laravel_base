<?php

namespace Database\Factories;

use App\Models\ContentNav;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $title = fake()->words(2, true);

        return [
            //
            // 'content_nav_id' => ContentNav::factory()->create([
            //     'type' => 1
            // ]),
            'title' => Str::title($title),
            'slug' => Str::slug($title),
            'text' => '<p>' . implode('</p><p>', fake()->paragraphs(2)) . '</p>',
            'abstract' => '<p>' . fake()->paragraph(1) . '</p>',
            'filename' => 'contents/' . fake()->image(storage_path('app') . '/public/contents', 300, 300, null, false),
        ];
    }
}

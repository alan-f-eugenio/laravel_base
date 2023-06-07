<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\ContentNav;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ContentSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //

        if (File::isDirectory(storage_path('app') . '/public/contents')) {
            File::cleanDirectory(storage_path('app') . '/public/contents');
        } else {
            File::makeDirectory(storage_path('app') . '/public/contents', 0755, true, true);
        }

        Content::factory(3)
            ->sequence([
                'content_nav_id' => ContentNav::factory()->create([
                    'type' => 1,
                ]),
            ], [
                'content_nav_id' => ContentNav::factory()->create([
                    'type' => 1,
                ]),
            ], [
                'content_nav_id' => ContentNav::factory()->create([
                    'type' => 1,
                ]),
            ])
            ->create();

        Content::factory(9)
            ->sequence([
                'content_nav_id' => ContentNav::factory()->create([
                    'type' => 2,
                ]),
            ], [
                'content_nav_id' => ContentNav::factory()->create([
                    'type' => 2,
                ]),
            ], [
                'content_nav_id' => ContentNav::factory()->create([
                    'type' => 2,
                ]),
            ])
            ->create();
    }
}

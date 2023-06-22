<?php

namespace Modules\Content\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Content\Entities\Content;
use Modules\Content\Entities\ContentNav;

class ContentDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

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

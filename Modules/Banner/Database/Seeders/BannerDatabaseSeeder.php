<?php

namespace Modules\Banner\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Entities\BannerLocal;

class BannerDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        if (File::isDirectory(storage_path('app') . '/public/banners')) {
            File::cleanDirectory(storage_path('app') . '/public/banners');
        } else {
            File::makeDirectory(storage_path('app') . '/public/banners', 0755, true, true);
        }

        Banner::factory(5)
            ->sequence(fn ($sequence) => ['ordem' => $sequence->index + 1])
            ->create([
                'local_id' => BannerLocal::factory()->create(),
            ]);
        Banner::factory(6)
            ->sequence(fn ($sequence) => ['ordem' => $sequence->index + 1])
            ->create([
                'local_id' => BannerLocal::factory()->create(),
            ]);
    }
}

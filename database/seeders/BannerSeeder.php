<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerLocal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
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

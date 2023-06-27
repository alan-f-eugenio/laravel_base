<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            UserSeeder::class,
            DefineSeeder::class,
            // ContactSeeder::class,
            // EmailSeeder::class,
            // BannerSeeder::class,
            // ContentSeeder::class,
            // CustomerSeeder::class,
            // CouponSeeder::class,
            // ProductCategorySeeder::class,
            // ProductAttributeOptSeeder::class,
        ]);
    }
}

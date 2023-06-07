<?php

namespace Database\Seeders;

use App\Models\Define;
use Illuminate\Database\Seeder;

class DefineSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        Define::factory()->create();
    }
}

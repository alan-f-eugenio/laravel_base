<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        User::factory()->create([
            'name' => 'CGDW',
            'email' => 'admin@cgdw.com.br',
            'password' => bcrypt('1@comercial.'),
        ]);
    }
}

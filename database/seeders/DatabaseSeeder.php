<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@mg.com',
            'password' => Hash::make('password'),
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        for ($i = 0; $i < 10; $i++) {
            $serialNumber = \App\Models\SerialNumber::factory()->create();
            \App\Models\MissingTranslation::factory(rand(50, 200))->create([
                'serial_number' => $serialNumber->name,
            ]);
        }
    }
}

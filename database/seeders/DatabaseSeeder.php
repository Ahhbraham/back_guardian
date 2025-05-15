<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create one user for each role
        User::factory()->create([
            'name' => 'Abraham',
            'email' => 'Abraham@gmail.com',
            'role_id' => 1, // User role
            'password' => bcrypt('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Police',
            'email' => 'police@guardian.com',
            'role_id' => 2, // Police role
            'password' => bcrypt('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Ambulance',
            'email' => 'ambulance@guardian.com',
            'role_id' => 3, // Ambulance role
            'password' => bcrypt('12345678'),
        ]);

        User::factory()->create([
            'name' => 'FireServices',
            'email' => 'fireservices@guardian.com',
            'role_id' => 4, // FireServices role
            'password' => bcrypt('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@guardian.com',
            'role_id' => 5, // Admin role
            'password' => bcrypt('12345678'),
        ]);
    }
}
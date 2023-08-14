<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create test user
        \App\Models\User::create([
            'name'              => 'Test User',
            'email'             => 'admin@admin.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('Admin@12345'),
            'remember_token'    => \Str::random(10),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin1@wsrms.com'],
            [
                'name' => 'Admin 1',
                'phone_number' => '0123456789',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $this->call([
            UserSeeder::class,
            SparePartSeeder::class,
        ]);
    }
}
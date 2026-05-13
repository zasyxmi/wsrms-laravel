<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@wsrms.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $technicianUser = User::updateOrCreate(
            ['email' => 'tech@wsrms.com'],
            [
                'name' => 'Technician One',
                'password' => Hash::make('password'),
                'role' => 'technician',
            ]
        );

        Technician::updateOrCreate(
            ['user_id' => $technicianUser->id],
            [
                'phone_number' => '0123456789',
                'specialization' => 'Phone and Laptop Repair',
                'availability_status' => 'available',
            ]
        );

        $customerUser = User::updateOrCreate(
            ['email' => 'customer@wsrms.com'],
            [
                'name' => 'Customer One',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        Customer::updateOrCreate(
            ['user_id' => $customerUser->id],
            [
                'phone_number' => '0112233445',
                'address' => 'Kuala Lumpur, Malaysia',
            ]
        );
    }
}
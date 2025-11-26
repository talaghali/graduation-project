<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '+963999999999',
            'date_of_birth' => '1990-01-01',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'terms_accepted' => true,
            'email_verified_at' => now(),
        ]);
    }
}

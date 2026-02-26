<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'Global Admin',
                'password' => Hash::make('azertyuiop'),
                'is_global_admin' => true,
                'is_banned' => false,
            ]
        );
    }
}

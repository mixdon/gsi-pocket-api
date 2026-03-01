<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::firstOrCreate(
            ['email' => 'example1@mail.net'],
            [
                'id' => Str::uuid(),
                'full_name' => 'User 1',
                'password' => Hash::make('password'),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'example2@mail.net'],
            [
                'id' => Str::uuid(),
                'full_name' => 'User 2',
                'password' => Hash::make('password'),
            ]
        );

        $this->command->info("User 1 ID: {$user1->id}");
        $this->command->info("User 2 ID: {$user2->id}");
    }
}
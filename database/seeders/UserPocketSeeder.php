<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPocket;
use App\Models\User;
use Illuminate\Support\Str;

class UserPocketSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::where('email', 'example1@mail.net')->first();
        $user2 = User::where('email', 'example2@mail.net')->first();

        if (!$user1 || !$user2) {
            $this->command->error("Users not found! Jalankan UserSeeder dulu.");
            return;
        }

        UserPocket::firstOrCreate(
            ['user_id' => $user1->id, 'name' => 'Pocket 1'],
            ['id' => Str::uuid(), 'balance' => 2000000]
        );

        UserPocket::firstOrCreate(
            ['user_id' => $user2->id, 'name' => 'Pocket 2'],
            ['id' => Str::uuid(), 'balance' => 1500000]
        );
    }
}
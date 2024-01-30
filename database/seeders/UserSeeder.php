<?php

namespace Database\Seeders;

use App\Models\User;
use Nette\Utils\Random;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'pseudo' => 'admin',
            'password' => Hash::make('Azerty99@'),
            'email' => 'admin@admin.fr',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => 1,
        ]);

        User::create([
            'pseudo' => 'user',
            'password' => Hash::make('Azerty99@'),
            'email' => 'user@user.fr',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => 2,
        ]);

        User::factory(8)->create();
    }
}

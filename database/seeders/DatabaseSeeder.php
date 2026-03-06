<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::query()->create([
            'name' => 'Usuário Admin',
            'email' => 'ominimundo@email.com',
            'password' => bcrypt(123456),
        ]);
    }
}

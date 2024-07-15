<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'sekretaris']);

        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('secret'),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'sekretaris',
            'email' => 'sekretaris@mail.com',
            'password' => bcrypt('secret'),
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'anggota 1',
            'email' => 'anggota1@mail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}

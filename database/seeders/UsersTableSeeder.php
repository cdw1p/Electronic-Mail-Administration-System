<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Role
        User::create([
            'name'           => 'Administrator',
            'email'          => 'admin@distrive.id',
            'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role'           => 'admin',
            'status'         => '1',
            'remember_token' => 'null'
        ]);

        // Users Role
        User::create([
            'name'           => 'Graselina Geraldiawati',
            'email'          => 'grasel.gg@gmail.com',
            'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role'           => 'user',
            'status'         => '1',
            'remember_token' => 'null'
        ]);
    }
}

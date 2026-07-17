<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['nrp' => '2052004'],
            [
                'nama' => 'bayu',
                'password' => Hash::make('2052004'),
                'role' => 'admin',
            ]
        );
    }
}
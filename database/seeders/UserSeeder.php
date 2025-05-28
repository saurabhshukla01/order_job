<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Saurabh V2. Shukla',
            'email' => 'saurabh.shukla+v2@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}


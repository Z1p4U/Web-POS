<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("asdffdsa"),
            "role" => "admin",
            "gender" => 'male'
        ]);

        User::factory()->create([
            "name" => "staff",
            "phone" => "09777888666",
            "date_of_birth" => "4.9.1998",
            "gender" => "female",
            "address" => "nay yar ma thi",
            "role" => "staff",
            "email" => "staff@gmail.com",
            "password" => Hash::make("asdffdsa"),
        ]);
    }
}

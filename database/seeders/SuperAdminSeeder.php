<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::updateOrCreate(
        ['email' => 'rayatechpangandaran@gmail.com'],
        [
            'nama' => 'Super Admin',
            'email' => 'rayatechpangandaran@gmail.com',
            'password' => Hash::make('karuniaabadi'),
            'role' => 'superadmin',
        ]
    );
    }
}
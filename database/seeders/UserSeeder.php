<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Francisco Orca',
            'email' => 'francisco.orca@example.com',
            'password' => Hash::make('Fr4nc15c0.0rc423$'),
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'Miguel Barajas',
            'email' => 'miguel.barajas@example.com',
            'password' => Hash::make('M1gu3l.b4r4j4523$'),
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'Filemon Hurtado Díaz',
            'email' => 'filemon.hurtado1234@example.com',
            'password' => Hash::make('F1l3m0n.hurt4d023$'),
            'role_id' => 1,
        ]);
    }
}

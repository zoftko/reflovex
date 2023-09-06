<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Board::create([
            'uuid' => 'FCDR567NAK7U',
            'name' => 'Main classroom',
            'ip' => '192.168.2.56',
            'last_seen' => now(),
        ]);
        Board::create([
            'uuid' => 'FXXGFSK8HG35',
            'name' => 'Telecomunications room',
            'ip' => '192.168.2.67',
            'last_seen' => now(),
        ]);
        Board::create([
            'uuid' => 'FCDR567NAK7U',
            'name' => 'Main classroom',
        ]);
    }
}

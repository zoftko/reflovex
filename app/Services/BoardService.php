<?php

namespace App\Services;

use App\Models\Board;

class BoardService
{
    //Method to retrieve last session
    public function boardsCount(): int
    {
        return Board::count();
    }
}

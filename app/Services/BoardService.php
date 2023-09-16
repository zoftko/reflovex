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

    /*
     * Retrieve board by UUID
     */
    public function boardByUUID(string $uuid):Board|null{
        return Board::where('uuid', $uuid)->first();
    }
}

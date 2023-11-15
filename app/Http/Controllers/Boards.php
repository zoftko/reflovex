<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Session;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Boards extends Controller
{
    public function boards(): View
    {
        return view('boards');
    }

    public function sessions(Request $request): View
    {
        return view('boardSessions', [
            'id' => $request->id
        ]);
    }
}

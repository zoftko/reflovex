<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;

class Boards extends Controller
{
    public function boards(): View
    {
        return view('boards');
    }
}

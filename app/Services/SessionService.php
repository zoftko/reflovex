<?php

namespace App\Services;

use App\Models\Session;

class SessionService
{
    //Method to retrieve last session
    public function lastSession(): ?Session
    {
        return Session::latest()
            ->with('measurements')
            ->first();
    }
}

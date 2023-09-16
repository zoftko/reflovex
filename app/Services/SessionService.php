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

    /**
     * Retrieve the amount of sessions stored in the database.
     */
    public function sessionsCount(): int
    {
        return Session::count();
    }

    /**
     * Method to create a new session with array data
     */
    public function createSession(array $data): Session{
        return Session::create($data);
    }
}

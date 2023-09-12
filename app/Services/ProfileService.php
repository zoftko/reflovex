<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    //Method to retrieve last session
    public function profilesCount(): int
    {
        return Profile::count();
    }
}
